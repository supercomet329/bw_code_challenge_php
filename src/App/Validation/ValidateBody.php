<?php

namespace App\Validation;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Validate that the request has a legit body. If not, it'll return a 400 (Bad Request) response
 *
 * Class ValidateBody
 * @package App\Validation
 */
class ValidateBody implements MiddlewareInterface
{
    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        /** @var array $body */
        $body = $request->getParsedBody();
        if (empty($body)) {
            return new JsonResponse('invalid body', 400);
        }

        return $handler->handle($request);
    }
}
