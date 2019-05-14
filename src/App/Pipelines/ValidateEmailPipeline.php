<?php

namespace App\Pipelines;

use App\Validation\ValidateEmailRequestBody;
use Psr\Container\ContainerInterface;
use Zend\Expressive\MiddlewareFactory;
use Zend\Stratigility\MiddlewarePipe;

class ValidateEmailPipeline
{
    public function __invoke(ContainerInterface $container)
    {
        $factory  = $container->get(MiddlewareFactory::class);
        $pipeline = new MiddlewarePipe();
        $pipeline->pipe($factory->prepare($container->get(ValidateEmailRequestBody::class)));

        return $pipeline;
    }
}
