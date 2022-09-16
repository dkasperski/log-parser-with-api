<?php

declare(strict_types=1);

namespace App\LegalOne\LogApiBundle\ValueObject;

class ServiceName
{
    private string $name;

    public function __construct(string $name)
    {
        $this->ensureIsValidName($name);

        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    protected function ensureIsValidName(string $name): void
    {
        if (!preg_match('/[a-zA-Z]+-[a-zA-Z]+/', $name)) {
            throw new \InvalidArgumentException('Not valid service name');
        }
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
