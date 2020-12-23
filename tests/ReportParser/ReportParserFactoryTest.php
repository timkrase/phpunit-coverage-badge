<?php


namespace ReportParser;


use PHPUnit\Framework\TestCase;
use PhpUnitCoverageBadge\ReportParser\CloverReportParser;
use PhpUnitCoverageBadge\ReportParser\HtmlReportParser;
use PhpUnitCoverageBadge\ReportParser\ReportParserFactory;

class ReportParserFactoryTest extends TestCase
{
    public function testCloverParser(): void
    {
        $factory = new ReportParserFactory();

        $parser = $factory->createReportParser('clover');

        $this->assertInstanceOf(CloverReportParser::class, $parser);
    }

    public function testHtmlParser(): void
    {
        $factory = new ReportParserFactory();

        $parser = $factory->createReportParser('html');

        $this->assertInstanceOf(HtmlReportParser::class, $parser);

    }

    public function testInvalidParser(): void
    {
        $factory = new ReportParserFactory();

        $this->expectException(\InvalidArgumentException::class);
        $parser = $factory->createReportParser('abcde');
    }
}