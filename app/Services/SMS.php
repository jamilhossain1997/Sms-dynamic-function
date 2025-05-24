<?php

namespace App\Services;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class SMS 
{
    protected $countryCode;

    public function country($code)
    {
        $this->countryCode = strtolower($code);
        return $this;
    }

    public function send($to, $message, $type = 'sms')
    {
        $gateway = $this->resolveGateway($this->countryCode);
        $config = config("sms.gateways.{$gateway}");

        if ($type === 'whatsapp') {
            return $this->sendWhatsappTemplate($to, $message, $config);
        }
        if ($gateway === 'infobip') {
            return $this->sendViaInfobip($to, $message, $config);
        } elseif ($gateway === 'twilio') {
            return $this->sendViaTwilio($to, $message, $config);
        }

        throw new \Exception("Unsupported gateway: $gateway");
    }

    protected function resolveGateway($country)
    {
        $providers = config('sms.providers');
        foreach ($providers as $gateway => $countries) {
            if (in_array($country, $countries)) {
                return $gateway;
            }
        }
        return config('sms.default_gateway');
    }

    protected function sendViaInfobip($to, $message, $config)
    {
        $url = rtrim($config['api_url'], '/') . '/sms/2/text/advanced';
        $payload = [
            'messages' => [
                [
                    'from' => $config['wa_from'] ?? 'INFOSMS',
                    'destinations' => [['to' => $to]],
                    'text' => $message,
                ],
            ],
        ];

        return Http::withHeaders([
            'Authorization' => 'App ' . $config['api_key'],
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($url, $payload)->json();
    }

    protected function sendViaTwilio($to, $message, $config)
    {
        return [
            'to' => $to,
            'message' => $message,
            'status' => 'sent via twilio',
        ];
    }

    protected function sendWhatsappTemplate($to, $templateData, $config)
    {
        $url = rtrim($config['api_url'], '/') . '/whatsapp/1/message/template';

        $payload = [
            'messages' => [
                [
                    'from' => $config['wa_from'],
                    'to' => $to,
                    'messageId' => Str::uuid()->toString(),
                    'content' => [
                        'templateName' => $templateData['templateName'],
                        'templateData' => [
                            'body' => [
                                'placeholders' => $templateData['placeholders']
                            ]
                        ],
                        'language' => $templateData['language'] ?? 'en'
                    ]
                ]
            ]
        ];

        return Http::withHeaders([
            'Authorization' => 'App ' . $config['api_key'],
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($url, $payload)->json();
    }
}
