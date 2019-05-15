<?php

namespace App\Adapters;

use App\Models\EmailInterface;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Send an email somewhere
 *
 * Class EmailSender
 * @package App\Adapters
 */
class EmailSender implements EmailSenderInterface
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var string
     */
    private $uri;
    /**
     * @var string
     */
    private $apiKey;

    public function __construct(Client $emailClient, string $uri, string $apiKey)
    {
        $this->client = $emailClient;
        $this->uri    = $uri;
        $this->apiKey = $apiKey;
    }

    /**
     * @param EmailInterface $email
     * @return ResponseInterface
     */
    public function sendEmail(EmailInterface $email): ResponseInterface
    {
        return $this->client->post($this->uri, $email->getConfig($this->apiKey));
    }
}
