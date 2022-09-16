<?php

declare(strict_types=1);

namespace App\LegalOne\LogParserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \DateTimeImmutable;

/**
 * @ORM\Entity(repositoryClass="App\LegalOne\LogParserBundle\Repository\LogRepository")
 * @ORM\Table(name="logs")
 */
class Log
{
    private const DATE_FORMAT = 'd/M/Y:H:i:s';

    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     */
    private string $id;

    /** @ORM\Column(type="string", length=50) */
    private string $service;

    /** @ORM\Column(type="datetime") */
    private DateTimeImmutable $date;

    /** @ORM\Column(type="string", length=6) */
    private string $method;

    /** @ORM\Column(type="string", length=100) */
    private string $path;

    /** @ORM\Column(type="string", length=3) */
    private string $code;

    /** @ORM\Column(type="integer", name="current_line_number") */
    private int $currentLineNumber;

    public function __construct(LogId $id)
    {
        $this->id = $id->getValue();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getService(): string
    {
        return $this->service;
    }

    public function getDate(): DateTimeImmutable
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

    public function setService(string $service): void
    {
        $this->service = $service;
    }

    public function setDate(DateTimeImmutable $date): void
    {
        $this->date = $date;
    }

    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function setCurrentLineNumber(int $currentLineNumber): void
    {
        $this->currentLineNumber = $currentLineNumber;
    }

    public static function create(
        LogId $logId,
        string $service,
        string $date,
        string $method,
        string $path,
        string $code,
        int $currentLineNumber,
    ): self {
        $log = new self($logId);
        $log->setService($service);
        $log->setDate(DateTimeImmutable::createFromFormat(self::DATE_FORMAT, $date));
        $log->setMethod($method);
        $log->setPath($path);
        $log->setCode($code);
        $log->setCurrentLineNumber($currentLineNumber);

        return $log;
    }
}
