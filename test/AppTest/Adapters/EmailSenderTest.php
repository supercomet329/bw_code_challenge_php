<?php

namespace App\Adapters;

use App\Models\EmailInterface;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ResponseInterface;

class EmailSenderTest extends TestCase
{
    /**
     * @var ObjectProphecy|Client
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
    /**
     * @var EmailSender
     */
    private $testSubject;

    public function setUp()
    {
        $this->client      = $this->prophesize(Client::class);
        $this->uri         = uniqid('this->uri_', true);
        $this->apiKey      = uniqid('this->apiKey_', true);
        $this->testSubject = new EmailSender(
            $this->client->reveal(),
            $this->uri,
            $this->apiKey
        );
    }

    /**
     * @test
     */
    public function itWillCallClientWithEmailAndConfig()
    {
        /** @var EmailInterface $email */
        $email = $this->prophesize(EmailInterface::class);
        $email->getConfig($this->apiKey)->shouldBeCalled()->willReturn(
            ['config to' => 'send email']
        );
        $response = $this->prophesize(ResponseInterface::class);
        $this->client->post($this->uri, ['config to' => 'send email'])->shouldBeCalled()
            ->willReturn($response);
        $this->testSubject->sendEmail($email->reveal());
    }
}
