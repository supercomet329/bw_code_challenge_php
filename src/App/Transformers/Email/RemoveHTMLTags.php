<?php

namespace App\Transformers\Email;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Remove HTML tags from body field
 *
 * Class RemoveHTMLTags
 * @package App\Transformers\Email
 */
class RemoveHTMLTags implements MiddlewareInterface
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
        /** @var array $email */
        $email = $request->getParsedBody();
        $email['body'] = strip_tags($email['body']);
        return $handler->handle($request->withParsedBody($email));
    }
}
