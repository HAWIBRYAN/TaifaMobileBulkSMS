<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmsController;


Route::post('/sms/send', [SmsController::class, 'send']);
