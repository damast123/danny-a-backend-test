<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TodoListController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('todo-lists/export-excel', [TodoListController::class, 'exportXls']);
Route::apiResource('todo-lists', TodoListController::class);
