<?php

namespace App\Services;

use Psr\Container\ContainerInterface;

class EmailServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new EmailService();
    }
}
