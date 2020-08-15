<?php

declare(strict_types=1);

namespace F9Web\LaravelRedirectResponseMacros;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\ServiceProvider;

use function trans;

class LaravelRedirectResponseMacrosServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang/', 'f9web-laravel-redirect-response-macros');

        $this->publishes(
            [
                __DIR__ . '/../resources/lang' => resource_path('lang/vendor/f9web-laravel-redirect-response-macros'),
            ]
        );

        $this->registerMacros();
    }

    private function registerMacros()
    {
        $this->registerHelper();

        foreach (['success', 'info', 'danger', 'warning'] as $type) {
            RedirectResponse::macro(
                $type,
                function ($message) use ($type) {
                    return $this->with($type, $message);
                }
            );
        }

        $key = 'f9web-laravel-redirect-response-macros::messages.';

        RedirectResponse::macro(
            'created',
            function ($route = null) use ($key) {
                $message = null === $route
                    ? trans("{$key}created-min")
                    : trans("{$key}created", ['url' => $route]);

                return $this->with('success', $message);
            }
        );

        RedirectResponse::macro(
            'updated',
            function ($message = null) use ($key) {
                return $this->with(
                    'success',
                    $message ?? trans("{$key}updated")
                );
            }
        );

        RedirectResponse::macro(
            'deleted',
            function ($message = null) use ($key) {
                return $this->with('success', $message ?? trans("{$key}deleted"));
            }
        );

        RedirectResponse::macro(
            'error',
            function ($message) {
                return $this->with(
                    'error',
                    $message = $this->determineMessage($message)
                );
            }
        );

        RedirectResponse::macro(
            'errorNotFound',
            function ($message = null) use ($key) {
                $message = $this->determineMessage($message);

                return $this->with('error', $message ?? trans("{$key}not-found"));
            }
        );

        RedirectResponse::macro(
            'authorized',
            function ($message = null) use ($key) {
                return $this->with('success', $message ?? trans("{$key}authorized"));
            }
        );

        RedirectResponse::macro(
            'unAuthorized',
            function ($message = null) use ($key) {
                $message = $this->determineMessage($message);

                return $this->with('error', $message ?? trans("{$key}un-authorized"));
            }
        );
    }

    public function register()
    {
        //
    }

    private function registerHelper()
    {
        RedirectResponse::macro(
            'determineMessage',
            function ($message = null) {
                return $message instanceof Exception
                    ? $message->getMessage()
                    : ($message ?? null);
            }
        );
    }
}
