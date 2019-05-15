<?php

namespace App\Models;

use PHPUnit\Framework\TestCase;

class MailgunEmailTest extends TestCase
{
    /**
     * @var MailgunEmail
     */
    private $testSubject;

    public function setUp()
    {
        $this->testSubject = new MailgunEmail();
    }

    /**
     * @test
     */
    public function itWillReturnAnArrayForAClientToSend()
    {
        $to       = uniqid('to_', true);
        $toName   = uniqid('toName_', true);
        $from     = uniqid('from_', true);
        $fromName = uniqid('fromName_', true);
        $subject  = uniqid('subject_', true);
        $body     = uniqid('body_', true);
        $apiKey   = uniqid('apiKey_', true);
        $data     = [
            'to'        => $to,
            'to_name'   => $toName,
            'from'      => $from,
            'from_name' => $fromName,
            'subject'   => $subject,
            'body'      => $body,
        ];
        $this->testSubject->exchangeArray($data);
        $this->assertEquals(
            [
                'multipart' => [
                    [
                        'name'     => 'from',
                        'contents' => "{$fromName} <{$from}>",
                    ],
                    [
                        'name'     => 'to',
                        'contents' => "{$toName} <{$to}>",
                    ],
                    [
                        'name'     => 'subject',
                        'contents' => $subject,
                    ],
                    [
                        'name'     => 'text',
                        'contents' => $body,
                    ],
                ],
                'auth'      => ['api', $apiKey],
            ],
            $this->testSubject->getConfig($apiKey)
        );
    }
}
