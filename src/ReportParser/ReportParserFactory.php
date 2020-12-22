<?php


namespace PhpUnitCoverageBadge\ReportParser;


use InvalidArgumentException;

class ReportParserFactory
{
    public function createReportParser(string $reportType): ReportParserInterface
    {
        switch ($reportType) {
            case 'clover':
                return new CloverReportParser();
            case 'html':
                return new HtmlReportParser();
            default:
                throw new InvalidArgumentException('Report type ' . $reportType . ' not found. Supported report types are: clover');
        }
    }
}