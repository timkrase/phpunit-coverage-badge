<?php declare(strict_types=1);

namespace ReportParser;

use Assert\Assertion;
use PHPUnit\Framework\TestCase;
use PhpUnitCoverageBadge\ReportParser\CloverReportParser;

class CloverReportParserTest extends TestCase
{
    public function testExpectInvalidArgumentExceptionIfFileNotFound()
    {
        $coverageParser = new CloverReportParser();

        $this->expectExceptionCode(Assertion::INVALID_FILE);
        $coverageParser->getCodeCoverage('../../tests/resources/clover33.xml');
    }

    public function testExpectExceptionIfFileIsNotProperlyFormatted()
    {
        $coverageParser = new CloverReportParser();

        $this->expectExceptionMessage(CloverReportParser::NO_METRICS_IN_CLOVER_FILE_EXCEPTION);
        $coverageParser->getCodeCoverage('../../tests/resources/wrong_clover.xml');
    }
    
    public function testEmptyCloverWithoutCoveredElements()
    {
        $coverageParser = new CloverReportParser();

        $coverage = $coverageParser->getCodeCoverage('../../tests/resources/clover_0_elements.xml');
        $this->assertEquals(0, $coverage);
    }

    public function testWithValidCloverFile()
    {
        $coverageParser = new CloverReportParser();

        $coverage = $coverageParser->getCodeCoverage('../../tests/resources/clover_valid_29.xml');
        $this->assertEqualsWithDelta(29.6875, $coverage, 0.01);
    }

}
