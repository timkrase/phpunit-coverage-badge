<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class PhpUnitCoverageBadgeTest extends TestCase
{
    public function testExpectInvalidArgumentExceptionIfFileNotFound()
    {
        $coverageParser = new \PhpUnitCoverageBadge\CoverageReportParser('clover33.xml');

        $this->expectException(InvalidArgumentException::class);
        $coverageParser->getCodeCoverage();
    }
}
