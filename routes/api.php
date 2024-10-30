<?php

declare(strict_types=1);

use App\Http\Controllers\ScrapingController;
use Illuminate\Support\Facades\Route;

Route::controller(ScrapingController::class)->group(function () {
    Route::post('/jobs', 'create');
    Route::get('/jobs', 'index');
    Route::get('/jobs/{id}', 'show');
    Route::delete('/jobs/{id}', 'destroy');
});
