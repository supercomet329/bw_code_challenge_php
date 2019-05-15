<?php

namespace App\Adapters;

use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;

class EmailSenderFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $emailClient     = new Client();
        $config          = $container->get('config')['email'];
        $currentProvider = $config['current_provider'];
        $uri             = $config['providers'][$currentProvider]['uri'];
        $apiKey          = $config['providers'][$currentProvider]['api_key'];

        return new EmailSender($emailClient, $uri, $apiKey);
    }
}
