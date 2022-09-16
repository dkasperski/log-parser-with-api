<?php

declare(strict_types=1);

namespace App\LegalOne\LogParserBundle\LogParser;

use App\LegalOne\LogParserBundle\LogParser\Exception\MatchException;
use App\LegalOne\LogParserBundle\LogParser\Exception\ParserException;

abstract class AbstractSingleLineParser implements SingleLineParserInterface
{
    public function parseSingleLine(string $line): array
    {
        $match = @preg_match($this->getPattern(), $line, $matches);

        if ($match === false) {
            $error = error_get_last();
            throw new ParserException("Matcher failure. Please check if given pattern is valid. ({$error["message"]})");
        }

        if (!$match) {
            throw new MatchException('Given line does not match predefined pattern.');
        }

        return $this->prepareParsedData($matches);
    }

    protected function prepareParsedData(array $matches): array
    {
        $filtered = array_filter(array_keys($matches), 'is_string');
        $result = array_intersect_key($matches, array_flip($filtered));
        return array_filter($result);
    }

    abstract protected function getPattern(): string;
}
