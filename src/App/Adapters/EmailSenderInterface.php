<?php

namespace App\Adapters;

use App\Models\EmailInterface;
use Psr\Http\Message\ResponseInterface;

interface EmailSenderInterface
{
    /**
     * @param EmailInterface $email
     * @return ResponseInterface
     */
    public function sendEmail(EmailInterface $email): ResponseInterface;
}
