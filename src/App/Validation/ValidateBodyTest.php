<?php

namespace App\Validation;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ValidateBodyTest extends TestCase
{
    /**
     * @var ValidateBody
     */
    private $testSubject;

    public function setUp()
    {
        $this->testSubject = new ValidateBody();
    }

    /**
     * @test
     */
    public function itWillReturnA400WhenBodyIsEmpty()
    {
        /** @var ServerRequestInterface $request */
        $request = $this->prophesize(ServerRequestInterface::class);
        /** @var RequestHandlerInterface $handler */
        $handler = $this->prophesize(RequestHandlerInterface::class);
        /** @var ResponseInterface $response */
        $response = $this->prophesize(ResponseInterface::class);
        $handler->handle($request)->willReturn($response);
        /** @var array $body */
        $request->getParsedBody()->willReturn([]);
        $result = $this->testSubject->process($request->reveal(), $handler->reveal());
        $this->assertEquals(400, $result->getStatusCode());
    }

    /**
     * @test
     */
    public function itWillNotReturnA400WhenBodyIsNotEmpty()
    {
        /** @var ServerRequestInterface $request */
        $request = $this->prophesize(ServerRequestInterface::class);
        /** @var RequestHandlerInterface $handler */
        $handler = $this->prophesize(RequestHandlerInterface::class);
        /** @var ResponseInterface $response */
        $response = $this->prophesize(ResponseInterface::class);
        $response->getStatusCode()->willReturn(200);
        $handler->handle($request)->willReturn($response->reveal());
        /** @var array $body */
        $request->getParsedBody()->willReturn(['some' => 'data']);
        $result = $this->testSubject->process($request->reveal(), $handler->reveal());
        $this->assertEquals(200, $result->getStatusCode());
    }
}
