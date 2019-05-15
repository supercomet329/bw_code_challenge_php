<?php

namespace App\Services;

use App\Adapters\EmailSenderInterface;
use App\Models\EmailInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Transform an HTTP Request into an Email Object, and send it
 *
 * Class EmailService
 * @package App\Services
 */
class EmailService
{
    /**
     * @var EmailSenderInterface
     */
    private $emailSender;
    /**
     * @var EmailInterface
     */
    private $email;

    public function __construct(
        EmailSenderInterface $emailSender,
        EmailInterface $email
    ) {
        $this->emailSender = $emailSender;
        $this->email       = $email;
    }

    public function sendEmail(array $body): ResponseInterface
    {
        $this->email->exchangeArray($body);

        return $this->emailSender->sendEmail($this->email);
    }
}
