<?php

namespace App\Middleware\Email;

use App\Services\EmailService;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SendEmailTest extends TestCase
{
    /**
     * @var ObjectProphecy|EmailService
     */
    private $emailService;
    /**
     * @var SendEmail
     */
    private $testSubject;

    public function setUp()
    {
        $this->emailService = $this->prophesize(EmailService::class);
        $this->testSubject  = new SendEmail($this->emailService->reveal());
    }

    /**
     * @test
     */
    public function itWillCallEmailService()
    {
        /** @var ServerRequestInterface $request */
        $request = $this->prophesize(ServerRequestInterface::class);
        /** @var RequestHandlerInterface $handler */
        $handler = $this->prophesize(RequestHandlerInterface::class);
        /** @var ResponseInterface $response */
        $response = $this->prophesize(ResponseInterface::class);
        $handler->handle($request)->willReturn($response);
        /** @var array $body */
        $request->getParsedBody()->shouldBeCalled()->willReturn(['body' => 'contents']);
        /** @var ResponseInterface $apiResponse */
        $apiResponse = $this->prophesize(ResponseInterface::class);
        /** @var StreamInterface $stream */
        $stream = $this->prophesize(StreamInterface::class);
        $apiResponse->getBody()->willReturn($stream);
        $stream->getContents()->willReturn('response from API');
        $apiResponse->getStatusCode()->willReturn(200);
        $this->emailService->sendEmail(['body' => 'contents'])->shouldBeCalled()->willReturn($apiResponse);
        $this->testSubject->process($request->reveal(), $handler->reveal());
    }
}
