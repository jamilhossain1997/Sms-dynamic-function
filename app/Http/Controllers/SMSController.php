<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SmsService;

class SMSController extends Controller
{
    public function sendRegularSMS()
    {
      $response=SmsService::setCountry('bd')->driver('moblie_route')->send('8801739921850', 'Hello Jamil Hossain');
        return response()->json([
            'status' => 'SMS Sent',
            'messages'=>$response
        ],200);
    }
}
