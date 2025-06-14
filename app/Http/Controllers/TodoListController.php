<?php

namespace App\Http\Controllers;

use App\Models\TodoList;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreTodoListRequest;
use App\Services\TodoListService;
use App\Services\ReturnResponse;
use App\Exports\TodoListsExport;

class TodoListController extends Controller
{
    protected TodoListService $todoListService;
    protected ReturnResponse $returnResponse;

    public function __construct(TodoListService $todoListService, ReturnResponse $returnResponse)
    {
        $this->todoListService = $todoListService;
        $this->returnResponse = $returnResponse;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function exportXls(Request $request)
    {
      $date = $this->todoListService->setDate();

      $filters = $request->only(['title', 'assignee', 'due_start', 'due_end', 'time_min', 'time_max', 'status', 'priority']);

      return Excel::download(new TodoListsExport($filters), "todo_lists_{$date}.xls", \Maatwebsite\Excel\Excel::XLS);
    }

    public function chartData(Request $request)
    {
        $type = $request->only(['type']);

        $data = $this->todoListService->getChartData($type);

        return $this->returnResponse->ResponseMessage($data, 200,'','success');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoListRequest $request)
    {
        $validated = $request->validated();

        if ($this->todoListService->isDateLate($validated['due_date'])) {
            return $this->returnResponse->ResponseMessage([], 400, 'Due date cannot be in the past', 'error');
        }

        $validated['time_tracked'] = $validated['time_tracked'] ?? 0;
        $validated['status'] = $validated['status'] ?? 'pending';

        $todo = TodoList::create($validated);

        return $this->returnResponse->ResponseMessage(["data" => $todo], 201, '', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(TodoList $todoList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TodoList $todoList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TodoList $todoList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TodoList $todoList)
    {
        //
    }
}
