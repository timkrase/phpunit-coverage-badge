<?php


namespace PhpUnitCoverageBadge\ReportParser;

use Assert\Assertion;
use DOMDocument;

class HtmlReportParser implements ReportParserInterface
{
    const TOTAL_ROW = 2;
    const COVERAGE_DETAIL_COLUMNS = [3, 6, 9];

    public function getCodeCoverage(string $coverageReportPath): float
    {
        $domDocument = new DOMDocument();

        //Suppress "tag header invalid warnings"
        libxml_use_internal_errors(true);
        $domDocument->loadHTMLFile($coverageReportPath);
        libxml_use_internal_errors(false);

        $row = $domDocument->getElementsByTagName('tr')->item(self::TOTAL_ROW);
        Assertion::notNull($row, 'Could not parse HTML report. Table row with total report results not found.');

        $rowData = $row->getElementsByTagName('td');

        $totalElements = 0;
        $totalElementsCovered = 0;
        foreach (self::COVERAGE_DETAIL_COLUMNS as $detailColumn) {
            $coverageString = $rowData->item($detailColumn);
            Assertion::notNull($coverageString, 'Could not parse HTML report. Table data entry with covered elements not found.');
            $coverageString = $coverageString->nodeValue;

            $coverageData = explode('/', $coverageString);

            //Using the regex as trim can't remove the whitespace which leads to wrongly converted int values
            $elementsCovered = preg_replace('/^\p{Z}+|\p{Z}+$/u', '', $coverageData[0]);
            $elements = preg_replace('/^\p{Z}+|\p{Z}+$/u', '', $coverageData[1]);

            $totalElements += (int) $elements;
            $totalElementsCovered += (int) $elementsCovered;
        }

        //Prevent divide by zero errors
        $totalElements = $totalElements === 0 ? 1 : $totalElements;

        return $totalElementsCovered / $totalElements * 100;
    }
}