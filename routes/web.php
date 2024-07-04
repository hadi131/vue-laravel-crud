<?php

use App\Http\Controllers\TelController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::apiResource('/tel',TelController::class);
