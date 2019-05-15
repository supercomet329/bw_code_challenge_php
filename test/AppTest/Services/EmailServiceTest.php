<?php

namespace App\Services;

use App\Adapters\EmailSender;
use App\Adapters\EmailSenderInterface;
use App\Models\EmailInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ResponseInterface;

class EmailServiceTest extends TestCase
{
    /**
     * @var ObjectProphecy|EmailSender
     */
    private $emailSender;
    /**
     * @var ObjectProphecy|EmailInterface
     */
    private $email;
    /**
     * @var EmailService
     */
    private $testSubject;

    public function setUp()
    {
        $this->emailSender = $this->prophesize(EmailSenderInterface::class);
        $this->email       = $this->prophesize(EmailInterface::class);
        $this->testSubject = new EmailService($this->emailSender->reveal(), $this->email->reveal());
    }

    /**
     * @test
     */
    public function itWillCallExchangeArrayAndCallService()
    {
        $to       = uniqid('to_', true);
        $toName   = uniqid('toName_', true);
        $from     = uniqid('from_', true);
        $fromName = uniqid('fromName_', true);
        $subject  = uniqid('subject_', true);
        $body     = uniqid('body_', true);
        $body     = [
            'to'        => $to,
            'to_name'   => $toName,
            'from'      => $from,
            'from_name' => $fromName,
            'subject'   => $subject,
            'body'      => $body,
        ];
        $this->email->exchangeArray($body)->shouldBeCalled();
        $response = $this->prophesize(ResponseInterface::class);
        $this->emailSender->sendEmail($this->email)->shouldBeCalled()->willReturn($response);
        $this->testSubject->sendEmail($body);
    }
}
