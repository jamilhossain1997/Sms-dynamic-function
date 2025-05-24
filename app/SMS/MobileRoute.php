<?php

namespace App\SMS;

use App\SMS\SmsInterface;

class MobileRoute implements SmsInterface
{
    protected string $countryCode = '';
    protected string $gatewayName = 'moblie_route';
    protected array $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function send(string $to, string $message)
    {
        $params = [
            'api_id' => $this->config['api_id'] ?? '',
            'api_password' => $this->config['api_password'] ?? '',
            'sms_type' => $this->config['sms_type'] ?? '',
            'encoding' => $this->config['encoding'] ?? '',
            'sender_id' => $this->config['sender_id'] ?? '',
            'phonenumber' => $to,
            'textmessage' => urlencode($message),
            'callback_url' => $this->config['callback_url'] ?? '',
        ];

        $url = $this->config['api_url'] . '?' . http_build_query($params);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        return [
            'http_code' => $httpCode,
            'response' => $response,
            'error' => $error,
        ];
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
