<?php

namespace App\Pipelines;

use App\Validation\ValidateBody;
use App\Validation\ValidateEmailRequestBody;
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
        $pipeline->pipe($factory->prepare($container->get(ValidateEmailRequestBody::class)));
//        $pipeline->pipe($factory->prepare($container->get(TODO::class)));

        return $pipeline;
    }
}
