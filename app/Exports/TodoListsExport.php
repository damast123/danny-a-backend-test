<?php

namespace App\Exports;

use App\Models\TodoList;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TodoListsExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $data;

    public function __construct($filters = [])
    {
        $this->data = TodoList::getFilteredTodoList($filters);
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return ['Title', 'Assignee', 'Due Date', 'Time Tracked', 'Status', 'Priority'];
    }
    public function map($todo): array
    {
        return [
            $todo->title,
            $todo->assignee,
            $todo->due_date,
            (string) $todo->time_tracked,
            $todo->status,
            $todo->priority,
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $rowCount = count($this->data) + 2; // +2 for header and 1-based index
                $totalTodos = count($this->data);
                $totalTime = $this->data->sum('time_tracked');

                $event->sheet->setCellValue("A{$rowCount}", 'Total Todos');
                $event->sheet->setCellValue("B{$rowCount}", $totalTodos);
                $event->sheet->setCellValue("C{$rowCount}", 'Total Time Tracked');
                $event->sheet->setCellValue("D{$rowCount}", $totalTime);
            }
        ];
    }
}
