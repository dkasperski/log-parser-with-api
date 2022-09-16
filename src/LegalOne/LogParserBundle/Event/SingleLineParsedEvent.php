<?php

declare(strict_types=1);

namespace App\LegalOne\LogParserBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;

final class SingleLineParsedEvent extends Event
{
    private string $service;

    private string $date;

    private string $method;

    private string $path;

    private string $code;

    private int $currentLineNumber;

    public function __construct(string $service, string $date, string $method, string $path, string $code, int $currentLineNumber)
    {
        $this->service = $service;
        $this->date = $date;
        $this->method = $method;
        $this->path = $path;
        $this->code = $code;
        $this->currentLineNumber = $currentLineNumber;
    }

    public function getService(): string
    {
        return $this->service;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getCurrentLineNumber(): int
    {
        return $this->currentLineNumber;
    }
}
