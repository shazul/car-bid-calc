<?php

use App\Http\Controllers\BidCalculatorController;
use Illuminate\Support\Facades\Route;

Route::post('/calculate-bid', [BidCalculatorController::class, 'calculate']);