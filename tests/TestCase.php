<?php

namespace F9Web\LaravelRedirectResponseMacros\Tests;

use F9Web\LaravelRedirectResponseMacros\LaravelRedirectResponseMacrosServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     * @return array|string[]
     */
    protected function getPackageProviders($app): array
    {
        return [
            LaravelRedirectResponseMacrosServiceProvider::class,
        ];
    }
}
