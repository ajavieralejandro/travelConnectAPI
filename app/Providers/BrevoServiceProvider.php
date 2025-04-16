<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Configuration;
use GuzzleHttp\Client;

class BrevoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(TransactionalEmailsApi::class, function () {
            $apiKey = config('services.brevo.key');

            $config = Configuration::getDefaultConfiguration()
                ->setApiKey('api-key', $apiKey);

            return new TransactionalEmailsApi(new Client(), $config);
        });
    }
}
