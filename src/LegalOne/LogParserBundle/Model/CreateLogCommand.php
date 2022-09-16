<?php

declare(strict_types=1);

namespace App\LegalOne\LogParserBundle\Model;

final class CreateLogCommand
{
    private string $service;

    private string $date;

    private string $method;

    private string $path;

    private string $code;

    private int $currentLineNumber;

    public function getService(): string
    {
        return $this->service;
    }

    public function setService(string $service): void
    {
        $this->service = $service;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getCurrentLineNumber(): int
    {
        return $this->currentLineNumber;
    }

    public function setCurrentLineNumber(int $currentLineNumber): void
    {
        $this->currentLineNumber = $currentLineNumber;
    }
}
