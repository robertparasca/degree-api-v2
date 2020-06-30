<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'account_activated'])->group(function () {
    Route::get('/me', 'AuthController@me');
    Route::get('/logout', 'AuthController@logout');
    Route::get('/import-status', 'ImportFilesLogController@index');

    Route::get('/staff', 'StaffController@index');
    Route::post('/staff', 'StaffController@store');
    Route::get('/staff/{id}', 'StaffController@show');
    Route::put('/staff/{id}', 'StaffController@update');
    Route::delete('/staff/{id}', 'StaffController@destroy');

    Route::get('/students', 'StudentController@index');
    Route::get('/students/{id}', 'StudentController@show');
    Route::put('/students/{id}', 'StudentController@update');
    Route::delete('/students/{id}', 'StudentController@destroy');
    Route::post('/students/import', 'StudentController@import');

    Route::get('/tickets', 'TicketController@index');
    Route::post('/tickets', 'TicketController@store');
    Route::put('/tickets/{id}', 'TicketController@update');
    Route::delete('/tickets/{id}', 'TicketController@destroy');
    Route::post('/tickets/validate/{id}', 'TicketController@validateTicket');
    Route::post('/tickets/reject/{id}', 'TicketController@rejectTicket');
    Route::get('/tickets/chart-admin', 'TicketController@chartAdmin');
    Route::get('/tickets/chart-student', 'TicketController@chartStudent');

    Route::post('/scholarships/import', 'ScholarshipController@import');

    Route::get('/institute', 'InstituteController@index');
});

Route::get('/tickets/pdf/{id}', 'TicketController@downloadTicketPDF');

Route::post('/login', 'AuthController@login');
Route::post('/activate-account', 'AuthController@activateAccount');
