<?php

namespace PhpUnitCoverageBadge\ReportParser;

interface ReportParserInterface
{
    /**
     * Returns the code coverage as a percentage (e.g. 65.12%)
     *
     * @param string $coverageReportPath
     *
     * @return float
     */
    public function getCodeCoverage(string $coverageReportPath): float;
}