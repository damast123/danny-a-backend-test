<?php

namespace App\Http\Controllers;

use App\Models\TodoList;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\StoreTodoListRequest;
use App\Services\TodoListService;
use App\Services\ReturnResponse;

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

        return $this->returnResponse->ResponseMessage($todo, 201, '', 'success');
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
