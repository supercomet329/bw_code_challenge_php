<?php

namespace App\Validation\Email;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ValidateRequiredFieldsTest extends TestCase
{
    /**
     * @var ValidateRequiredFields
     */
    private $testSubject;

    public function setUp()
    {
        $this->testSubject = new ValidateRequiredFields();
    }

    /**
     * @test
     * @dataProvider invalidFieldProvider
     */
    public function itWillReturnAnErrorWhenARequiredFieldIsMissing(array $body)
    {
        /** @var ServerRequestInterface $request */
        $request = $this->prophesize(ServerRequestInterface::class);
        /** @var RequestHandlerInterface $handler */
        $handler = $this->prophesize(RequestHandlerInterface::class);
        /** @var ResponseInterface $response */
        $response = $this->prophesize(ResponseInterface::class);
        $handler->handle($request)->willReturn($response);
        /** @var array $body */
        $request->getParsedBody()->willReturn($body);
        $result = $this->testSubject->process($request->reveal(), $handler->reveal());
        $this->assertEquals(422, $result->getStatusCode());
    }

    public function invalidFieldProvider()
    {
        return
            [
                [['to' => 'to value']],
                [['to_name' => 'to_name value']],
                [['from' => 'from value']],
                [['from_name' => 'from_name value']],
                [['subject' => 'subject value']],
                [['body' => 'body value']],
            ];
    }

    /**
     * @test
     */
    public function itWillNotReturnAnErrorWhenAllRequiredFieldsAreIncluded()
    {
        /** @var ServerRequestInterface $request */
        $request = $this->prophesize(ServerRequestInterface::class);
        /** @var RequestHandlerInterface $handler */
        $handler = $this->prophesize(RequestHandlerInterface::class);
        /** @var ResponseInterface $response */
        $response = $this->prophesize(ResponseInterface::class);
        $response->getStatusCode()->willReturn(200);
        $handler->handle($request)->willReturn($response);
        /** @var array $body */
        $request->getParsedBody()->willReturn(
            [
                'to'        => 'to value',
                'to_name'   => 'to_name value',
                'from'      => 'from value',
                'from_name' => 'from_name value',
                'subject'   => 'subject value',
                'body'      => 'body value',
            ]
        );
        $result = $this->testSubject->process($request->reveal(), $handler->reveal());
        $this->assertEquals(200, $result->getStatusCode());
    }
}
