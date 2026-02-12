<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Mock the Slack notification service.
     */
    protected function mockSlack(): \Mockery\MockInterface
    {
        return $this->mock(\App\Services\SlackNotificationService::class, function ($mock) {
            $mock->shouldReceive('notifyBilling')->andReturnNull();
            $mock->shouldReceive('notifyUser')->andReturnNull();
            $mock->shouldReceive('notifyLead')->andReturnNull();
            $mock->shouldReceive('notifyBug')->andReturnNull();
        });
    }
}
