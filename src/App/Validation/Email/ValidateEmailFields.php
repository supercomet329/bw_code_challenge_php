<?php

namespace App\Validation\Email;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Check that the email fields looks like a real email addresses
 *
 * Class ValidateEmailField
 * @package App\Validation\Email
 */
class ValidateEmailFields implements MiddlewareInterface
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
        $body      = $request->getParsedBody();
        $fromEmail = $body['from'];
        $toEmail   = $body['to'];
        // do whatever real email validation's we'd actually want to do
        if (strpos($fromEmail, '@') === false || strpos($toEmail, '@') === false) {
            return new JsonResponse('invalid email', 422);
        }

        return $handler->handle($request);
    }
}
