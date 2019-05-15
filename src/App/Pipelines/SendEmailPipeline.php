<?php

namespace App\Pipelines;

use App\Middleware\Email\SendEmail;
use App\Transformers\Email\RemoveHTMLTags;
use App\Validation\ValidateBody;
use Psr\Container\ContainerInterface;
use Zend\Expressive\MiddlewareFactory;
use Zend\Stratigility\MiddlewarePipe;

class SendEmailPipeline
{
    public function __invoke(ContainerInterface $container)
    {
        $factory  = $container->get(MiddlewareFactory::class);
        $pipeline = new MiddlewarePipe();
        $pipeline->pipe($factory->prepare($container->get(ValidateBody::class)));
        $pipeline->pipe($factory->prepare($container->get(ValidateEmailPipeline::class)));
        $pipeline->pipe($factory->prepare($container->get(RemoveHTMLTags::class)));
        $pipeline->pipe($factory->prepare($container->get(SendEmail::class)));

        return $pipeline;
    }
}
