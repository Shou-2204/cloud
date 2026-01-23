<?php

namespace App\Services\Sms;

use App\Services\Sms\Drivers\LogDriver;
use App\Services\Sms\Drivers\OvhDriver;
use App\Services\Sms\Drivers\TwilioDriver;
use Illuminate\Support\Manager;

class SmsManager extends Manager
{
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return config('sms.default', 'log');
    }

    /**
     * Create an instance of the Log driver.
     *
     * @return \App\Services\Sms\Drivers\LogDriver
     */
    protected function createLogDriver()
    {
        return new LogDriver();
    }

    /**
     * Create an instance of the Twilio driver.
     *
     * @return \App\Services\Sms\Drivers\TwilioDriver
     */
    protected function createTwilioDriver()
    {
        $config = config('sms.drivers.twilio');

        return new TwilioDriver(
            $config['sid'],
            $config['token'],
            $config['from']
        );
    }

    /**
     * Create an instance of the OVH driver.
     *
     * @return \App\Services\Sms\Drivers\OvhDriver
     */
    protected function createOvhDriver()
    {
        $config = config('sms.drivers.ovh');

        return new OvhDriver(
            $config['app_key'],
            $config['app_secret'],
            $config['consumer_key'],
            $config['endpoint'],
            $config['service_name']
        );
    }
}
