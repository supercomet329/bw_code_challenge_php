<?php

namespace App\Validation;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Check that all fields are included in request
 *
 * Class ValidateEmailRequestBody
 * @package App\Validation
 */
class ValidateRequiredFields implements MiddlewareInterface
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
        $body           = $request->getParsedBody();
        $requiredFields = ['to', 'to_name', 'from', 'from_name', 'subject', 'body'];
        $requestFields  = array_keys($body);
        $diff           = array_diff($requiredFields, $requestFields);
        if (empty($diff)) {
            return $handler->handle($request);
        }
        $missingFields = implode(', ', $diff);

        return new JsonResponse("$missingFields is required", 422);
    }
}
