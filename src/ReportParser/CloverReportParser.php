<?php

namespace PhpUnitCoverageBadge\ReportParser;

use Assert\Assert;
use Assert\Assertion;
use Assert\AssertionFailedException;
use Exception;
use SimpleXMLElement;

class CloverReportParser implements ReportParserInterface
{
    const NO_METRICS_IN_CLOVER_FILE_EXCEPTION = 'Could not parse metrics from clover file.
        Please check that xml node <metrics> does exist as a child of <project>';

    /**
     * @param string $coverageReportPath
     * @return float
     * @throws Exception
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

        return ($coveredElements / $elements) * 100;
    }

    /**
     * Extracts the report metrics from a phpunit clover report
     * Inspired by:
     * https://ocramius.github.io/blog/automated-code-coverage-check-for-github-pull-requests-with-travis/
     *
     * @param string $coverageReportPath
     * @return int[]
     * @throws AssertionFailedException
     */
    private function getReportMetrics(string $coverageReportPath): array
    {
        $fileName = __DIR__ . '/../../' . $coverageReportPath;

        Assertion::file($fileName);

        $xmlElement = new SimpleXMLElement(file_get_contents($fileName));
        $reportMetrics = $xmlElement->xPath('project/metrics')[0] ?? null;

        Assertion::notNull($reportMetrics, self::NO_METRICS_IN_CLOVER_FILE_EXCEPTION);

        $metricsAttributes = $reportMetrics->attributes();
        Assertion::notNull($metricsAttributes);

        Assertion::notNull($metricsAttributes->coveredelements);
        Assertion::notNull($metricsAttributes->elements);

        return [
            'elements' => (int) $metricsAttributes->elements,
            'coveredElements' => (int) $metricsAttributes->coveredelements,
        ];
    }
}