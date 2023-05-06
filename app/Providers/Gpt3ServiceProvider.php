<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class Gpt3ServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('gpt3', function () {
            $apiKey = config('services.gpt3.api_key');
            return new Client([
                'base_uri' => 'https://api.gpt3.5turbo.com/v1/',
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json'
                ]
            ]);
        });
    }
}
