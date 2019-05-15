<?php

namespace App\Models;

use Psr\Container\ContainerInterface;

class EmailInterfaceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config          = $container->get('config')['email'];
        $currentProvider = $config['current_provider'];
        $emailEntity     = $config['providers'][$currentProvider]['entity'];

        return new $emailEntity;
    }
}
