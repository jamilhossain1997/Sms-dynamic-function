<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SMSController;

Route::get('/send-sms', [SMSController::class, 'sendRegularSMS']);

































// Route::get('/whatsapp', [SMSController::class, 'sendWhatsAppMessage']);
// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('/j', function () {
//     return 'jamil';
// });



