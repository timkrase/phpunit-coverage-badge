<?php

namespace PhpUnitCoverageBadge;

use Exception;
use InvalidArgumentException;
use SimpleXMLElement;

class CoverageReportParser
{
    private string $coverageReportPath;

    public function __construct(string $coverageReportPath)
    {
        $this->coverageReportPath = $coverageReportPath;
    }

    public function getCodeCoverage(): float
    {
        $reportMetrics = $this->getReportMetrics();

        $coveredElements = (int) $reportMetrics['coveredelements'];
        $elements = (int) $reportMetrics['elements'];

        return ($coveredElements / $elements) * 100;
    }

    /**
     * Extracts the report metrics from a phpunit clover report
     * Inspired by:
     * https://ocramius.github.io/blog/automated-code-coverage-check-for-github-pull-requests-with-travis/
     *
     * @return SimpleXMLElement
     */
    private function getReportMetrics(): SimpleXMLElement
    {
        $fileName = __DIR__ . DIRECTORY_SEPARATOR .  '..' . DIRECTORY_SEPARATOR . $this->coverageReportPath;
        if (!file_exists($fileName)) {
            throw new InvalidArgumentException('Coverage clover file could not be found');
        }

        $xmlElement = new SimpleXMLElement(file_get_contents($fileName));
        $reportMetrics = $xmlElement->xPath('project/metrics')[0] ?? null;

        if ($reportMetrics === null) {
            throw new Exception('Could not parse metrics from clover file');
        }

        return $reportMetrics;
    }
}