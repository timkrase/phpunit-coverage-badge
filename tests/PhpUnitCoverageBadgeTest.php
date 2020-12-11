<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class PhpUnitCoverageBadgeTest extends TestCase
{
    /**
     * @covers \PhpUnitCoverageBadge\CoverageReportParser::getCodeCoverage
     * @covers \PhpUnitCoverageBadge\CoverageReportParser::getReportMetrics
     * @covers \PhpUnitCoverageBadge\CoverageReportParser::__construct
     */
    public function testExpectInvalidArgumentExceptionIfFileNotFound()
    {
        $coverageParser = new \PhpUnitCoverageBadge\CoverageReportParser('clover33.xml');

        $this->expectException(InvalidArgumentException::class);
        $coverageParser->getCodeCoverage();
    }
}
