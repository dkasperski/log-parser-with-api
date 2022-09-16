<?php

declare(strict_types=1);

namespace App\LegalOne\LogParserBundle\LogParser;

use App\LegalOne\LogParserBundle\LogParser\Exception\MatchException;
use App\LegalOne\LogParserBundle\LogParser\Exception\ParserException;

interface SingleLineParserInterface
{
    /**
     * @throws MatchException
     * @throws ParserException
     */
    public function parseSingleLine(string $line): array;
}
