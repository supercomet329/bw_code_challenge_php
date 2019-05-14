<?php

namespace App\Validation\Email;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ValidateAllFieldValuesAreStringsTest extends TestCase
{
    /**
     * @var ValidateAllFieldValuesAreStrings
     */
    private $testSubject;

    public function setUp()
    {
        $this->testSubject = new ValidateAllFieldValuesAreStrings();
    }

    /**
     * @test
     */
    public function itWillReturnAnErrorWhenAFieldIsNotAString()
    {
        /** @var ServerRequestInterface $request */
        $request = $this->prophesize(ServerRequestInterface::class);
        /** @var RequestHandlerInterface $handler */
        $handler = $this->prophesize(RequestHandlerInterface::class);
        /** @var ResponseInterface $response */
        $response = $this->prophesize(ResponseInterface::class);
        $handler->handle($request)->willReturn($response);
        /** @var array $body */
        $request->getParsedBody()->willReturn(['to' => 1]);
        $result = $this->testSubject->process($request->reveal(), $handler->reveal());
        $this->assertEquals(422, $result->getStatusCode());
    }

    /**
     * @test
     */
    public function itWillNotReturnAnErrorWhenAllFieldValuesAreStrings()
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
        $request->getParsedBody()->willReturn(['to' => 'string']);
        $result = $this->testSubject->process($request->reveal(), $handler->reveal());
        $this->assertEquals(200, $result->getStatusCode());
    }
}
