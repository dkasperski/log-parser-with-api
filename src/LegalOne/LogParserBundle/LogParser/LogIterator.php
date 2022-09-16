<?php

declare(strict_types=1);

namespace App\LegalOne\LogParserBundle\LogParser;

use App\LegalOne\LogParserBundle\LogParser\Exception\MatchException;
use App\LegalOne\LogParserBundle\LogParser\Exception\ParserException;
use SplFileObject;

class LogIterator implements \Iterator
{
    private SingleLineParserInterface $parser;

    private string $logFile;

    private ?SplFileObject $file = null;

    private ?string $currentLine = null;

    private int $currentLineNumber = 1;

    private ?int $startFromLineNumber;

    public function __construct(string $logFile, SingleLineParserInterface $parser, ?int $startFromLineNumber)
    {
        $this->logFile = $logFile;
        $this->parser = $parser;
        $this->startFromLineNumber = $startFromLineNumber;
    }

    public function __destruct()
    {
        $this->file = null;
    }

    /**
     * @throws ParserException
     */
    protected function getFile(): SplFileObject
    {
        if ($this->file === null) {
            $file = new SplFileObject($this->logFile);

            if ($file->getRealPath() === false) {
                throw new ParserException('Can not open log file.');
            }

            $this->file = $file;
        }

        return $this->file;
    }

    /**
     * @throws ParserException
     */
    protected function readSingleLine(): void
    {
        if ($this->getFile()->eof()) {
            return;
        }

        $buffer = '';

        while ($buffer === '') {
            if ($this->startFromLineNumber !== null) {
                $this->getFile()->seek($this->startFromLineNumber);
            }
            if (($buffer = $this->getFile()->fgets()) === '') {
                $this->currentLine = null;

                return;
            }
            $buffer = trim($buffer, "\n\r\0");
        }

        $this->currentLine = $buffer;
    }

    /**
     * @throws ParserException
     */
    public function current(): ?array
    {
        if ($this->currentLine === null) {
            $this->readSingleLine();
        }

        if ($this->currentLine === null) {
            return null;
        }

        try {
            $data = $this->parser->parseSingleLine($this->currentLine);
            $this->currentLineNumber = $this->startFromLineNumber ? $this->startFromLineNumber + 1 : $this->currentLineNumber;
            $data['current_line_number'] = $this->currentLineNumber;
            $this->currentLineNumber++;
            $this->startFromLineNumber = null;
        } catch (MatchException $exception) {
            $data = null;
        }

        return $data;
    }

    /**
     * @throws ParserException
     */
    public function next(): void
    {
        $this->readSingleLine();
    }

    public function key(): string
    {
        return $this->currentLine;
    }

    public function valid(): bool
    {
        return $this->getFile()->valid();
    }

    public function rewind(): void
    {
        $this->getFile()->rewind();
    }
}
