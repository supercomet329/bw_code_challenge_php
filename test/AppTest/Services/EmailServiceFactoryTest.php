<?php

namespace App\Services;

use App\Adapters\EmailSenderInterface;
use App\Models\EmailInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class EmailServiceFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function itWillDoWhatItNeedsTo()
    {
        $container    = $this->prophesize(ContainerInterface::class);
        $factory      = new EmailServiceFactory();
        $emailAdapter = $this->prophesize(EmailSenderInterface::class);
        $email        = $this->prophesize(EmailInterface::class);
        $container->get(EmailSenderInterface::class)->willReturn($emailAdapter);
        $container->get(EmailInterface::class)->willReturn($email);

        $result = $factory($container->reveal());
        $this->assertInstanceOf(EmailService::class, $result);
    }
}
