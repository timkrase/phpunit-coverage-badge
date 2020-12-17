<?php declare(strict_types=1);

use PhpUnitCoverageBadge\BadgeGenerator;
use PhpUnitCoverageBadge\ReportParser\CloverReportParser;
use PhpUnitCoverageBadge\ReportParser\ReportParserInterface;
use PhpUnitCoverageBadge\WorkflowService;

return [
    ReportParserInterface::class => DI\create(CloverReportParser::class),
    BadgeGenerator::class => DI\autowire(),
    WorkflowService::class => DI\autowire(),
];