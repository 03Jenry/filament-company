<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(ApiController::class)->group(function () {
    Route::post('/login', 'login')->name('api.login');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/getCompanies', [ApiController::class, 'index']);
});
