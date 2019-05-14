<?php

namespace App\Pipelines;

use App\Validation\Email\ValidateAllFieldValuesAreStrings;
use App\Validation\Email\ValidateEmailFields;
use App\Validation\Email\ValidateRequiredFields;
use Psr\Container\ContainerInterface;
use Zend\Expressive\MiddlewareFactory;
use Zend\Stratigility\MiddlewarePipe;

/**
 * Validations for POST /email path
 *
 * Class ValidateEmailPipeline
 * @package App\Pipelines
 */
class ValidateEmailPipeline
{
    public function __invoke(ContainerInterface $container)
    {
        $factory  = $container->get(MiddlewareFactory::class);
        $pipeline = new MiddlewarePipe();
        $pipeline->pipe($factory->prepare($container->get(ValidateRequiredFields::class)));
        $pipeline->pipe($factory->prepare($container->get(ValidateAllFieldValuesAreStrings::class)));
        $pipeline->pipe($factory->prepare($container->get(ValidateEmailFields::class)));

        return $pipeline;
    }
}
