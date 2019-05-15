<?php

namespace App\Services;

use App\Adapters\EmailSenderInterface;
use App\Models\EmailInterface;
use Psr\Container\ContainerInterface;

class EmailServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $emailAdapter = $container->get(EmailSenderInterface::class);
        $email        = $container->get(EmailInterface::class);

        return new EmailService($emailAdapter, $email);
    }
}
