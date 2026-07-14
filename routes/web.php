<?php

use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;


Route::name('frontend.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});
