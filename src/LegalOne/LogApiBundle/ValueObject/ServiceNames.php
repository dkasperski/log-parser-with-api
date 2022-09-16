<?php

declare(strict_types=1);

namespace App\LegalOne\LogApiBundle\ValueObject;

use ArrayIterator;

class ServiceNames
{
    private array $names;

    public function __construct(ServiceName ...$names) {
        $this->names = $names;
    }

    public function getNames(): array
    {
        return $this->names;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->names);
    }
}
