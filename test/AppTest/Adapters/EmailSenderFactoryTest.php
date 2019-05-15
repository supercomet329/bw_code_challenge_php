<?php

namespace App\Adapters;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class EmailSenderFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function itWillDoWhatItNeedsTo()
    {
        $container = $this->prophesize(ContainerInterface::class);
        $factory   = new EmailSenderFactory();
        $container->get('config')->shouldBeCalled()->willReturn(
            [
                'email' => [
                    'current_provider' => 'some provider',
                    'providers'        => [
                        'some provider' => [
                            'uri'     => 'some uri',
                            'api_key' => 'secret_api_key',
                        ],
                    ],
                ],
            ]
        );

        $result = $factory($container->reveal());
        $this->assertInstanceOf(EmailSender::class, $result);
    }
}
