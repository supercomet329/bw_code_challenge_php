<?php

namespace App\Models;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class EmailInterfaceFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function itWillDoWhatItNeedsTo()
    {
        $container     = $this->prophesize(ContainerInterface::class);
        $factory       = new EmailInterfaceFactory();
        $emailEntities = [MailChimpEmail::class, MailgunEmail::class];
        $randomEntity  = $emailEntities[array_rand($emailEntities)];
        $container->get('config')->shouldBeCalled()->willReturn(
            [
                'email' => [
                    'current_provider' => 'some email provider',
                    'providers'        => [
                        'some email provider' => [
                            'entity' => $randomEntity,
                        ],
                    ],
                ],
            ]
        );

        $result = $factory($container->reveal());
        $this->assertInstanceOf(EmailInterface::class, $result);
        $this->assertInstanceOf($randomEntity, $result);
    }
}
