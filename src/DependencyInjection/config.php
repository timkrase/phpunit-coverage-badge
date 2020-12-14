<?php declare(strict_types=1);

use PhpUnitCoverageBadge\ReportParser\CloverReportParser;
use PhpUnitCoverageBadge\ReportParser\ReportParserInterface;

return [
    ReportParserInterface::class => DI\create(CloverReportParser::class),
    \PhpUnitCoverageBadge\BadgeGenerator::class => DI\autowire(),
    \PhpUnitCoverageBadge\WorkflowService::class => DI\autowire()
];