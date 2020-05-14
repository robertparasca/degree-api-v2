<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'account_activated'])->group(function () {
    Route::get('/me', 'AuthController@me');
    Route::get('/logout', 'AuthController@logout');

    Route::get('/staff', 'StaffController@index');
    Route::post('/staff', 'StaffController@store');
    Route::get('/staff/{id}', 'StaffController@show');
    Route::put('/staff/{id}', 'StaffController@update');
    Route::delete('/staff/{id}', 'StaffController@destroy');

    Route::get('/students', 'StudentController@index');
    Route::get('/students/{id}', 'StudentController@show');
    Route::put('/students/{id}', 'StudentController@update');
    Route::delete('/students/{id}', 'StudentController@destroy');

    Route::get('/tickets', 'TicketController@index');
    Route::post('/tickets', 'TicketController@store');
    Route::get('/tickets/{id}', 'TicketController@show');
    Route::put('/tickets/{id}', 'TicketController@update');
    Route::delete('/tickets/{id}', 'TicketController@destroy');
    Route::post('/tickets/validate/{id}', 'TicketController@validateTicket');
    Route::post('/tickets/reject/{id}', 'TicketController@rejectTicket');

});

Route::get('/tickets/pdf/{id}', 'TicketController@generateTicketPDF');

Route::post('/login', 'AuthController@login');
Route::post('/activate-account', 'AuthController@activateAccount');
