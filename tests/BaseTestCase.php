<?php

namespace Muscobytes\OzonSeller\Tests;

use Muscobytes\OzonSeller\Providers\WebhookServiceProvider;
use Orchestra\Testbench\TestCase;

class BaseTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            WebhookServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        //
    }
}