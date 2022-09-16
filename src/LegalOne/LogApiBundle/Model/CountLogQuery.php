<?php

declare(strict_types=1);

namespace App\LegalOne\LogApiBundle\Model;

use App\LegalOne\LogApiBundle\ValueObject\EndDate;
use App\LegalOne\LogApiBundle\ValueObject\ServiceName;
use App\LegalOne\LogApiBundle\ValueObject\StartDate;
use App\LegalOne\LogApiBundle\ValueObject\StatusCode;
use DateTimeImmutable;

final class CountLogQuery
{
    private ?array $serviceNames = [];

    private ?StartDate $startDate = null;

    private ?EndDate $endDate = null;

    private ?StatusCode $statusCode = null;

    public function __construct()
    {
    }

    public function getServiceNames(): ?array
    {
        return $this->serviceNames;
    }

    public function getStartDate(): ?StartDate
    {
        return $this->startDate;
    }

    public function getEndDate(): ?EndDate
    {
        return $this->endDate;
    }

    public function getStatusCode(): ?StatusCode
    {
        return $this->statusCode;
    }

    public function setServiceNames(?array $serviceNames): void
    {
        $this->serviceNames = $serviceNames;
    }

    public function setStartDate(?StartDate $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function setEndDate(?EndDate $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function setStatusCode(?StatusCode $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    public static function create(
        ?array $serviceNames,
        ?string $startDate,
        ?string $endDate,
        ?int $statusCode,
    ): self {
        $serviceNamesCollection = [];
        if ($serviceNames) {
            foreach($serviceNames as $serviceName) {
                $serviceNamesCollection[] = new ServiceName($serviceName);
            }
        }

        $query = new self();
        $query->setServiceNames($serviceNamesCollection);

        if ($startDate) {
            $query->setStartDate(new StartDate(new DateTimeImmutable($startDate)));
        }

        if ($endDate) {
            $query->setEndDate(new EndDate(new DateTimeImmutable($endDate)));
        }

        if ($statusCode) {
            $query->setStatusCode(new StatusCode($statusCode));
        }

        return $query;
    }
}
