<?php

namespace App\Validation\Email;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Makes sure every field passed in is a string
 *
 * Class ValidateFieldTypes
 * @package App\Validation\Email
 */
class ValidateAllFieldValuesAreStrings implements MiddlewareInterface
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
        foreach ($body as $fieldName => $value) {
            if (!is_string($value)) {
                return new JsonResponse("$fieldName field must be a string", 422);
            }
        }
        return $handler->handle($request);
    }
}
