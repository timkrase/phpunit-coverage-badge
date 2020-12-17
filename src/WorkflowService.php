<?php


namespace PhpUnitCoverageBadge;

use PhpUnitCoverageBadge\ReportParser\ReportParserInterface;

class WorkflowService
{
    private ReportParserInterface $reportParser;
    private BadgeGenerator $badgeGenerator;

    public function __construct(ReportParserInterface $reportParser, BadgeGenerator $badgeGenerator)
    {
        $this->reportParser = $reportParser;
        $this->badgeGenerator = $badgeGenerator;
    }

    public function run(): void
    {
        $config = new Config();

        $codeCoverage = $this->reportParser->getCodeCoverage($config->getCloverFilePath());

        $this->badgeGenerator->generateBadge($codeCoverage, $config->getBadgePath());

        if (!$config->isPushBadge()) {
            return;
        }

        exec('chmod +x ' . __DIR__ . '/commit_push_badge.sh');
        exec(__DIR__ . '/commit_push_badge.sh');
    }
}