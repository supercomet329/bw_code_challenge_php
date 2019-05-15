<?php

namespace App\Models;

use Zend\Stdlib\ArraySerializableInterface;

interface EmailInterface extends ArraySerializableInterface
{
    /**
     * Config representation that a Client can send
     * @param string $apiKey
     * @return array
     */
    public function getConfig(string $apiKey): array;
}
