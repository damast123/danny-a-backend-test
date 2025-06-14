<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    //
    protected $table = 'todo_lists';
    protected $fillable = [
        'title',
        'assignee',
        'due_date',
        'time_tracked',
        'status',
        'priority',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'time_tracked' => 'integer',
    ];

    public function scopeFilterByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeFilterByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public static function getTodoList(array $select = ['*'])
    {
        return self::select($select)
            ->orderBy('due_date', 'desc');
    }

    public static function getFilteredTodoList($filters)
    {
        return self::getTodoList([
            'title',
            'assignee',
            'due_date',
            'time_tracked',
            'status',
            'priority'
        ])->filtered($filters)->get();
    }

    public function scopeFiltered($query, $filters)
    {
        if (!empty($filters['title'])) {
            $query->where('title', 'ilike', '%' . $filters['title'] . '%');
        }

        if (!empty($filters['assignee'])) {
            $assignees = explode(',', $filters['assignee']);
            $query->whereIn('assignee', $assignees);
        }

        if (!empty($filters['due_start']) && !empty($filters['due_end'])) {
            $query->whereBetween('due_date', [$filters['due_start'], $filters['due_end']]);
        }

        if (!empty($filters['time_min']) && !empty($filters['time_max'])) {
            $query->whereBetween('time_tracked', [(int)$filters['time_min'], (int)$filters['time_max']]);
        }

        if (!empty($filters['status'])) {
            $status_todo = explode(',', $filters['status']);
            $query->whereIn('status', $status_todo);
        }

        if (!empty($filters['priority'])) {
            $priority_todo = explode(',', $filters['priority']);
            $query->whereIn('priority', $priority_todo);
        }

        return $query;
    }

}
