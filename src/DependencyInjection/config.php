<?php declare(strict_types=1);

use PhpUnitCoverageBadge\BadgeGenerator;
use PhpUnitCoverageBadge\ReportParser\ReportParserFactory;
use PhpUnitCoverageBadge\ReportParser\ReportParserInterface;
use PhpUnitCoverageBadge\WorkflowService;
use PhpUnitCoverageBadge\GitService;

return [
    ReportParserInterface::class => DI\factory([ReportParserFactory::class, 'createReportParser'])
        ->parameter('reportType', getenv('INPUT_REPORT_TYPE')),
    BadgeGenerator::class => DI\autowire(),
    GitService::class => DI\autowire(),
    WorkflowService::class => DI\autowire(),
];