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
}
