<?php

namespace App\SMS;

use Illuminate\Support\Facades\Http;

class Infobip implements SmsInterface
{
    protected string $countryCode = '';
    protected string $gatewayName = 'infobip';
    protected array $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function send(string $to, string $message)
    {
        $url = rtrim($this->config['api_url'] ?? '');
        $payload = [
            'messages' => [
                [
                    'from' => $this->config['wa_from'] ?? 'INFOSMS',
                    'destinations' => [['to' => $to]],
                    'text' => $message,
                ],
            ],
        ];

        return Http::withHeaders([
            'Authorization' => 'App ' . ($this->config['api_key'] ?? ''),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($url, $payload)->json();
    }

    public function setCountry(string $country)
    {
        $this->countryCode = strtolower($country);
        return $this;
    }

    public function setGateway(string $gatewayName)
    {
        $this->gatewayName = $gatewayName;
        return $this;
    }
}
