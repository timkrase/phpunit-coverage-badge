<?php declare(strict_types=1);

return [
    ReportParserInterface::class => DI\create(\PhpUnitCoverageBadge\CloverReportParser::class)
];