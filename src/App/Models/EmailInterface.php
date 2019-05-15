<?php

namespace App\Models;

use Zend\Stdlib\ArraySerializableInterface;

interface EmailInterface extends ArraySerializableInterface
{
    public function getConfig(string $apiKey): array;
}
