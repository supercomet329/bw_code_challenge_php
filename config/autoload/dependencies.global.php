<?php

declare(strict_types=1);

use App\Pipelines\SendEmailPipeline;
use App\Pipelines\ValidateEmailPipeline;
use App\Validation\Email\ValidateAllFieldValuesAreStrings;
use App\Validation\ValidateBody;
use App\Validation\ValidateRequiredFields;

return [
    // Provides application-wide services.
    // We recommend using fully-qualified class names whenever possible as
    // service names.
    'dependencies' => [
        // Use 'aliases' to alias a service name to another service. The
        // key is the alias name, the value is the service to which it points.
        'aliases'    => [
            // Fully\Qualified\ClassOrInterfaceName::class => Fully\Qualified\ClassName::class,
        ],
        // Use 'invokables' for constructor-less services, or services that do
        // not require arguments to the constructor. Map a service name to the
        // class name.
        'invokables' => [
            // Fully\Qualified\InterfaceName::class => Fully\Qualified\ClassName::class,
            ValidateBody::class                     => ValidateBody::class,
            ValidateRequiredFields::class           => ValidateRequiredFields::class,
            ValidateAllFieldValuesAreStrings::class => ValidateAllFieldValuesAreStrings::class,
        ],
        // Use 'factories' for services provided by callbacks/factory classes.
        'factories'  => [
            SendEmailPipeline::class     => SendEmailPipeline::class,
            ValidateEmailPipeline::class => ValidateEmailPipeline::class
            // Fully\Qualified\ClassName::class => Fully\Qualified\FactoryName::class,
        ],
    ],
];
