<?php

declare(strict_types=1);

namespace App\LegalOne\LogParserBundle\LogParser;

class SingleLineParser extends AbstractSingleLineParser
{
    private string $format;

    public function __construct(string $format)
    {
        $this->format = $format;
    }

    protected function getPattern(): string
    {
        $replacements = [
            '%s' => '(?<service>\S+)',
            '%d' => '\[(?<date>\S+)',
            '%ms' => '(?<miliseconds>\S+)',
            '%m' => '\"(?<method>\S+)',
            '%p' => '(?<path>\S+)',
            '%hs' => '(?<http_standard>\S+)',
            '%c' => '(?<code>\S+)',
        ];

        $pattern = str_replace(array_keys($replacements), array_values($replacements), $this->format);

        return "/$pattern/";
    }
}
