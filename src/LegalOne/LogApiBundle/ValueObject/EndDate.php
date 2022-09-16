<?php

declare(strict_types=1);

namespace App\LegalOne\LogApiBundle\ValueObject;

use DateTimeImmutable;

class EndDate
{
    private DateTimeImmutable $date;

    public function __construct(DateTimeImmutable $date)
    {
        $this->date = $date;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}
