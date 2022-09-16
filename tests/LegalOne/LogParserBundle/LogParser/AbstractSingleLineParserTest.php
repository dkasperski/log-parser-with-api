<?php

declare(strict_types=1);

namespace Tests\LegalOne\LogParserBundle\LogParser;

use App\LegalOne\LogParserBundle\LogParser\AbstractSingleLineParser;
use App\LegalOne\LogParserBundle\LogParser\Exception\MatchException;
use App\LegalOne\LogParserBundle\LogParser\Exception\ParserException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AbstractSingleLineParserTest extends TestCase
{
    /**
     * @return MockObject&AbstractSingleLineParser
     */
    protected function getParser(): AbstractSingleLineParser
    {
        return $this->getMockBuilder(AbstractSingleLineParser::class)
            ->setMethods(['prepareParsedData', 'getPattern'])
            ->getMock();
    }

    public function testParseSingleLineExceptionMatcherFailure(): void
    {
        $parser = $this->getParser();
        $parser->expects($this->once())->method('getPattern')->willReturn('invalid_regexp_pattern');
        $this->expectException(ParserException::class);
        $parser->parseSingleLine('test string');
    }

    public function testParseSingleLineExceptionNoMatches(): void
    {
        $parser = $this->getParser();
        $parser->expects($this->once())->method('getPattern')->willReturn('/\d+/');
        $this->expectException(MatchException::class);
        $parser->parseSingleLine('test string');
    }

    public function testParseSingleLine(): void
    {
        $parser = $this->getParser();
        $parser->expects($this->once())->method('getPattern')->willReturn('/.*/');
        $parser->parseSingleLine('test string');
    }
}
