<?php


namespace PhpUnitCoverageBadge\ReportParser;


use PHPUnit\Framework\TestCase;

class HtmlReportParserTest extends TestCase
{
    public function testWithInvalidHtmlReport(): void
    {
        $coverageParser = new HtmlReportParser();

        $this->expectException(\InvalidArgumentException::class);

        $coverageParser->getCodeCoverage(__DIR__ . '/../resources/html/empty_index.html');
    }

    public function testWithValidHtmlReport(): void
    {
        $coverageParser = new HtmlReportParser();

        $expectedCoverage = 91.44736842105;
        $coverage = $coverageParser->getCodeCoverage(__DIR__ . '/../resources/html/index.html');

        $this->assertEqualsWithDelta($expectedCoverage, $coverage, 0.001);
    }
}