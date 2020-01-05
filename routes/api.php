<?php

use Illuminate\Http\Request;

Route::post('register', 'Api\Auth\RegisterController@register');
Route::post('login', 'Api\Auth\LoginController@login');

// API version 1.0
Route::middleware('auth:api')->prefix('v1')->namespace('Api')->group(function () {
    // Income Categories 
    Route::get('categories/incomes', 'IncomeCategoryController@index');
    Route::post('categories/incomes', 'IncomeCategoryController@create');
    Route::put('categories/incomes/{id}', 'IncomeCategoryController@edit');
    Route::delete('categories/incomes/{id}', 'IncomeCategoryController@destroy');

    // Expense Categories 
    Route::get('categories/expenses', 'ExpenseCategoryController@index');
    Route::post('categories/expenses', 'ExpenseCategoryController@create');
    Route::put('categories/expenses/{id}', 'ExpenseCategoryController@edit');
    Route::delete('categories/expenses/{id}', 'ExpenseCategoryController@destroy');

    // Incomes
    Route::get('incomes', 'IncomeController@index');
    Route::get('incomes/{id}', 'IncomeController@detail');
    Route::post('incomes', 'IncomeController@store');
    Route::put('incomes/{id}', 'IncomeController@edit');
    Route::delete('incomes/{id}', 'IncomeController@destroy');

    // Expenses
    Route::get('expenses', 'ExpenseController@index');
    Route::get('expenses/{id}', 'ExpenseController@detail');
    Route::post('expenses', 'ExpenseController@store');
    Route::put('expenses/{id}', 'ExpenseController@edit');
    Route::delete('expenses/{id}', 'ExpenseController@destroy');

    // Report API
    Route::get('report/day-detail', 'ReportController@dayDetail');
    Route::get('report/month-summary', 'ReportController@monthSummary');
    Route::get('report/year-summary/incomes/{year}', 'ReportController@yearIncomeSummary');
    Route::get('report/year-summary/expenses/{year}', 'ReportController@yearExpenseSummary');
    Route::get('report/categories/incomes/{year}/{month?}', 'ReportController@incomesReport');
    Route::get('report/categories/expenses/{year}/{month?}', 'ReportController@expensesReport');

    // Reset All Datas
    Route::post('reset', 'ResetAllController');
});
