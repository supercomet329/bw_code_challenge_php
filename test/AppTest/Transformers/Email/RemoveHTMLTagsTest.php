<?php

namespace App\Transformers\Email;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RemoveHTMLTagsTest extends TestCase
{
    /**
     * @var RemoveHTMLTags
     */
    private $testSubject;

    public function setUp()
    {
        $this->testSubject = new RemoveHTMLTags();
    }

    /**
     * @test
     */
    public function itWillRemoveHtmlTags()
    {
        /** @var ServerRequestInterface $request */
        $request = $this->prophesize(ServerRequestInterface::class);
        /** @var RequestHandlerInterface $handler */
        $handler = $this->prophesize(RequestHandlerInterface::class);
        /** @var ResponseInterface $response */
        $response = $this->prophesize(ResponseInterface::class);
        $handler->handle($request)->willReturn($response);
        /** @var array $body */
        $request->getParsedBody()->willReturn(['body' => '<h1>Your Bill</h1><p>$10</p>']);
        $request->withParsedBody(['body' => 'Your Bill$10'])->shouldBeCalled()->willReturn($request);
        $this->testSubject->process($request->reveal(), $handler->reveal());
    }
}
