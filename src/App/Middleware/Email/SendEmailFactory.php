<?php

namespace App\Middleware\Email;

use App\Services\EmailService;
use Psr\Container\ContainerInterface;

class SendEmailFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $emailService = $container->get(EmailService::class);

        return new SendEmail($emailService);
    }
}
