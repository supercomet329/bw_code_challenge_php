<?php

namespace App\Middleware\Email;

use App\Services\EmailService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Middleware to send emails. Assumed body has been validated. (See ValidateEmailPipeline)
 *
 * Class SendEmail
 * @package App\Middleware\Email
 */
class SendEmail implements MiddlewareInterface
{
    /**
     * @var EmailService
     */
    private $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }
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

        $this->emailService->sendEmail($body);

        return $handler->handle($request);
    }
}
