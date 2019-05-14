<?php

namespace App\Pipelines;

use App\Validation\Email\ValidateAllFieldValuesAreStrings;
use App\Validation\ValidateRequiredFields;
use Psr\Container\ContainerInterface;
use Zend\Expressive\MiddlewareFactory;
use Zend\Stratigility\MiddlewarePipe;

class ValidateEmailPipeline
{
    public function __invoke(ContainerInterface $container)
    {
        $factory  = $container->get(MiddlewareFactory::class);
        $pipeline = new MiddlewarePipe();
        $pipeline->pipe($factory->prepare($container->get(ValidateRequiredFields::class)));
        $pipeline->pipe($factory->prepare($container->get(ValidateAllFieldValuesAreStrings::class)));

        return $pipeline;
    }
}
