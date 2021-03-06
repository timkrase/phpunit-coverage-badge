<?php

namespace PhpUnitCoverageBadge\ReportParser;

use Assert\Assertion;
use Assert\AssertionFailedException;
use SimpleXMLElement;

class CloverReportParser implements ReportParserInterface
{
    const NO_METRICS_IN_CLOVER_FILE_EXCEPTION = 'Could not parse metrics from clover file.
        Please check that xml node <metrics> does exist as a child of <project>';

    /**
     * @throws AssertionFailedException
     */
    public function getCodeCoverage(string $coverageReportPath): float
    {
        $reportMetrics = $this->getReportMetrics($coverageReportPath);

        Assertion::keyExists($reportMetrics, 'coveredElements');
        Assertion::keyExists($reportMetrics, 'elements');

        $coveredElements = $reportMetrics['coveredElements'];
        $elements = $reportMetrics['elements'];

        //Prevent divide by zero errors
        $elements = $elements === 0 ? 1 : $elements;

        return $coveredElements / $elements * 100;
    }

    /**
     * Extracts the report metrics from a phpunit clover report
     * Inspired by:
     * https://ocramius.github.io/blog/automated-code-coverage-check-for-github-pull-requests-with-travis/
     *
     * @return int[]
     * @throws AssertionFailedException
     *
     * @psalm-suppress UndefinedPropertyFetch
     */
    private function getReportMetrics(string $coverageReportPath): array
    {
        Assertion::file($coverageReportPath);

        $xmlElement = new SimpleXMLElement(file_get_contents($coverageReportPath));
        $reportMetrics = $xmlElement->xPath('project/metrics')[0] ?? null;

        Assertion::notNull($reportMetrics, self::NO_METRICS_IN_CLOVER_FILE_EXCEPTION);

        $metricsAttributes = $reportMetrics->attributes();

        Assertion::notNull($metricsAttributes->coveredelements);
        Assertion::notNull($metricsAttributes->elements);

        return [
            'elements' => (int) $metricsAttributes->elements,
            'coveredElements' => (int) $metricsAttributes->coveredelements,
        ];
    }
}