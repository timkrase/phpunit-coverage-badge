<?php


namespace PhpUnitCoverageBadge;

use PhpUnitCoverageBadge\ReportParser\ReportParserInterface;

class WorkflowService
{
    private ReportParserInterface $reportParser;
    private BadgeGenerator $badgeGenerator;
    private GitService $gitService;

    public function __construct(
        ReportParserInterface $reportParser,
        BadgeGenerator $badgeGenerator,
        GitService $gitService
    ) {
        $this->reportParser = $reportParser;
        $this->badgeGenerator = $badgeGenerator;
        $this->gitService = $gitService;
    }

    public function run(): void
    {
        $config = new Config();

        $codeCoverage = $this->reportParser->getCodeCoverage($config->getReportFilePath());

        $this->badgeGenerator->generateBadge($codeCoverage, $config->getBadgePath());

        if (!$config->isPushBadge()) {
            return;
        }
        
        $this->gitService->pushBadge(
            $config->getCommitEmail(),
            $config->getCommitName(),
            $config->getCommitMessage(),
            $config->getRepoToken()
        );
    }
}