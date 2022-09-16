<?php

declare(strict_types=1);

namespace App\LegalOne\LogApiBundle\ValueObject;

class StatusCode
{
    private int $code;

    public function __construct(int $code)
    {
        $this->ensureIsValidName($code);

        $this->code = $code;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    protected function ensureIsValidName(int $code): void
    {
        if (!preg_match('/^\d{3}$/', (string) $code)) {
            throw new \InvalidArgumentException('Not valid status code');
        }
    }
}
