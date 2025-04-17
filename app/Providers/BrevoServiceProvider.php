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
       // Leemos la API Key desde el archivo de configuración 'services.php'
    $apiKey = config('services.brevo.key');

    // Configuramos la API Key y el host de Brevo
    $config = Configuration::getDefaultConfiguration()
                ->setApiKey('api-key', $apiKey)  // API Key desde config('services.brevo.key')
                ->setHost('https://api.brevo.com/v3');  // Actualizamos el host a Brevo
    return new TransactionalEmailsApi(new Client(), $config);

    }
}
