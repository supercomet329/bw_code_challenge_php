<?php

namespace App\Validation\Email;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ValidateEmailFieldsTest extends TestCase
{
    /**
     * @var ValidateEmailFields
     */
    private $testSubject;

    public function setUp()
    {
        $this->testSubject = new ValidateEmailFields();
    }

    /**
     * @test
     */
    public function itWillReturn422ForBogusEmail()
    {
        /** @var ServerRequestInterface $request */
        $request = $this->prophesize(ServerRequestInterface::class);
        /** @var RequestHandlerInterface $handler */
        $handler = $this->prophesize(RequestHandlerInterface::class);
        /** @var ResponseInterface $response */
        $response = $this->prophesize(ResponseInterface::class);
        $handler->handle($request)->willReturn($response);
        /** @var array $body */
        $request->getParsedBody()->willReturn(['from' => 'bad email', 'to' => 'another bad one']);
        $result = $this->testSubject->process($request->reveal(), $handler->reveal());
        $this->assertEquals(422, $result->getStatusCode());
    }

    /**
     * @test
     */
    public function itWillNotReturn422ForGoodEmails()
    {
        /** @var ServerRequestInterface $request */
        $request = $this->prophesize(ServerRequestInterface::class);
        /** @var RequestHandlerInterface $handler */
        $handler = $this->prophesize(RequestHandlerInterface::class);
        /** @var ResponseInterface $response */
        $response = $this->prophesize(ResponseInterface::class);
        $handler->handle($request)->willReturn($response);
        $response->getStatusCode()->willReturn(200);
        /** @var array $body */
        $request->getParsedBody()->willReturn(['from' => 'good@email', 'to' => 'another@good.email']);
        $result = $this->testSubject->process($request->reveal(), $handler->reveal());
        $this->assertEquals(200, $result->getStatusCode());
    }
}
