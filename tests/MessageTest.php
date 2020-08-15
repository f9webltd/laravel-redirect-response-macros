<?php

declare(strict_types=1);

namespace F9Web\LaravelRedirectResponseMacros\Tests;

use Exception;

use function resolve;

class MessageTest extends TestCase
{
    /**
     * @param  string  $method
     * @param  string  $sessionKey
     * @param  string  $expectedMessage
     * @param  string|null  $arguments
     *
     * @test
     * @dataProvider responseData
     */
    public function it_renders_expected_flash_data(
        string $method,
        string $sessionKey,
        string $expectedMessage,
        ?string $arguments = null
    ) {
        $response = resolve('redirect')->to('/')->$method($arguments);

        $this->assertTrue($response->getSession()->has($sessionKey));

        $this->assertEquals(
            $expectedMessage,
            $response->getSession()->get($sessionKey)
        );
    }

    /** @test */
    public function it_renders_exception_object_messages()
    {
        $exception = new Exception($message = 'Holy Rheostat!');

        foreach (['error', 'errorNotFound', 'unAuthorized'] as $method) {
            $response = resolve('redirect')->to('/')->$method($exception);
            $this->assertTrue($response->getSession()->has('error'));
            $this->assertEquals($message, $response->getSession()->get('error'));
        }
    }

    public function responseData(): array
    {
        return [
            [
                'deleted',
                'success',
                'The record was successfully deleted.',
            ],
            [
                'deleted',
                'success',
                $m = 'Wooo, deleted!',
                $m,
            ],
            [
                'updated',
                'success',
                'The record was successfully updated.',
            ],
            [
                'updated',
                'success',
                $m = 'Woo, updated',
                $m,
            ],
            [
                'created',
                'success',
                'The record was successfully created',
            ],
            [
                'created',
                'success',
                'The record was successfully created. <a href="/url" class="alert-link">View inserted record</a>.',
                '/url',
            ],
            [
                'errorNotFound',
                'error',
                'Sorry, the record could not be found.',
            ],
            [
                'authorized',
                'success',
                'Welcome back, you have been securely logged in',
            ],
            [
                'authorized',
                'success',
                $m = 'Custom message',
                $m,
            ],
            [
                'unAuthorized',
                'error',
                'You do not have permission to perform that action',
            ],
            [
                'unAuthorized',
                'error',
                $m = 'Holy Luther Burbank!',
                $m,
            ],
            [
                'error',
                'error',
                $m = 'Holy Graf Zeppelin!',
                $m,
            ],
            [
                'success',
                'success',
                $m = 'Holy Uncanny Photographic Mental Processes!',
                $m,
            ],
            [
                'info',
                'info',
                $m = 'Holy Astringent Plum-Like Fruit!',
                $m,
            ],
            [
                'danger',
                'danger',
                $m = 'Holy Taxidermy',
                $m,
            ],
            [
                'warning',
                'warning',
                $m = 'Holy Hurricane',
                $m,
            ],
        ];
    }
}
