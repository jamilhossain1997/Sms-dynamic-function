<?php

namespace App\SmsService;

use App\SMS\SmsInterface;
use App\SMS\Infobip;
use App\SMS\MobileRoute;
use InvalidArgumentException;
use RuntimeException;

class SmsManager 
{
  
    protected ?string $country = null;

    public function setCountry(string $country): self
    {
        $this->country = strtolower($country);
        return $this;
    }

    
    public function driver(?string $name = null): SmsInterface
    {
        $gateways = config('sms.gateways');

        if ($name === null && $this->country !== null) {
            foreach ($gateways as $gatewayName => $settings) {
                if (!empty($settings['country']) && in_array($this->country, $settings['country'])) {
                    $name = $gatewayName;
                    break;
                }
            }
        }

        $name = $name ?? config('sms.default');

        if (!isset($gateways[$name])) {
            throw new InvalidArgumentException("SMS driver [$name] is not defined in configuration.");
        }

        $driverClass = $this->getDriverClass($gateways[$name]['driver'] ?? $name);

        $config = $gateways[$name];

        return new $driverClass($config);
    }

   

    protected function getDriverClass(string $driver): string
    {
        $map = [
            'infobip'    => Infobip::class,
            'moblie_route'     => MobileRoute::class,
        ];

        if (!isset($map[$driver])) {
            throw new RuntimeException("SMS driver class for [$driver] is not mapped.");
        }

        return $map[$driver];
    }

 
    public function send(string $to, string $message, ?string $country = null)
    {
        if ($country !== null) {
            $this->setCountry($country);
        }

        return $this->driver()->send($to, $message);
    }
  
    
}
