<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [EmployeeController::class, 'viewIndex'])->name('employees.index');
Route::get('/employees', [EmployeeController::class, 'viewIndex'])->name('employees.index');
Route::get('/employees/create', [EmployeeController::class, 'viewCreate'])->name('employees.create');
Route::get('/employees/{employee}/edit', [EmployeeController::class, 'viewEdit'])->name('employees.edit');