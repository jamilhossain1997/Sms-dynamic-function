<?php
namespace App\SMS;

interface SmsInterface
{
    public function send(string $to, string $message);
    public function setCountry(string $country);
    public function setGateway(string $gatewayName);
}
