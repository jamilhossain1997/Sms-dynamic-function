<?php



return [

    'default' => env('SMS_DEFAULT_GATEWAY', 'moblie_route'),

    'gateways' => [

        'moblie_route' => [
            'driver' => 'moblie_route',
            'api_url' => env('CUSTOM_SMS_API_URL'),
            'api_id' => env('CUSTOM_SMS_API_ID'),
            'api_password' => env('CUSTOM_SMS_API_PASSWORD'),
            'encoding'=>env('CUSTOM_SMS_ENCODING'),
            'sms_type'=>env('CUSTOM_SMS_TYPE'),
            'sender_id' => env('CUSTOM_SMS_SENDER_ID'),
            'callback_url' => env('CUSTOM_SMS_CALLBACK'),
            'country' => ['bd'],
        ],

        'infobip' => [
            'driver' => 'infobip',
            'api_url' => env('SMS_INFOBIP_API_URL'),
            'api_key' => env('SMS_INFOBIP_API_KEY'),
            'wa_from' => env('SMS_INFOBIP_WA_FROM'),
            'country' => ['ma', 'in'],
        ],

        'twilio' => [
            'driver' => 'twilio',
            'api_url' => env('SMS_TWILIO_API_URL'),
            'api_key' => env('SMS_TWILIO_API_KEY'),
            'country' => ['uk', 'us'],
        ],
    ],
];


