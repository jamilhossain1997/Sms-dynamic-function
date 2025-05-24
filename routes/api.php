<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SMSController;

Route::post('/send-sms', [SMSController::class, 'sendRegularSMS']);
