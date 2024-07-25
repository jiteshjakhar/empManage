<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/employees', [EmployeeController::class, 'store']);
Route::get('/employees', [EmployeeController::class, 'index']);
Route::get('/employees/{employee}', [EmployeeController::class, 'show']);
Route::put('/employees/{employee}', [EmployeeController::class, 'update']);
Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy']);
Route::put('/employees/{employee}/status', [EmployeeController::class, 'updateStatus']);
