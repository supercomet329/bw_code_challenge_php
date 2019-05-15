<?php

namespace App\Models;

use PHPUnit\Framework\TestCase;

class MailChimpEmailTest extends TestCase
{
    /**
     * @var MailChimpEmail
     */
    private $testSubject;

    public function setUp()
    {
        $this->testSubject = new MailChimpEmail();
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
                'json' => [
                    'key'     => $apiKey,
                    'message' => [
                        'text'       => $body,
                        'subject'    => $subject,
                        'from_email' => $from,
                        'from_name'  => $fromName,
                        'to'         => [
                            [
                                'email' => $to,
                                'name'  => $toName,
                            ],
                        ],
                    ],
                ],
            ],
            $this->testSubject->getConfig($apiKey)
        );
    }
}
