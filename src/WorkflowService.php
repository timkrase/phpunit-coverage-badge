<?php


namespace PhpUnitCoverageBadge;

use PhpUnitCoverageBadge\ReportParser\ReportParserInterface;

class WorkflowService
{
    private Config $config;
    private ReportParserInterface $reportParser;
    private BadgeGenerator $badgeGenerator;

    public function __construct(ReportParserInterface $reportParser, BadgeGenerator $badgeGenerator)
    {
        $this->reportParser = $reportParser;
        $this->badgeGenerator = $badgeGenerator;
    }

    public function run()
    {
        $this->initConfig();

        $codeCoverage = $this->reportParser->getCodeCoverage($this->config->getCloverFilePath());

        $this->badgeGenerator->generateBadge($codeCoverage, $this->config->getBadgePath());

        if ($this->config->isPushBadge()) {
            exec('chmod +x ' . __DIR__ . '/commit_push_badge.sh');
            exec(__DIR__ . '/commit_push_badge.sh');
        }
    }

    private function initConfig(): void
    {
        $config = new Config();
        $config->setCloverFilePath(getenv('INPUT_CLOVER_REPORT'));
        $config->setBadgePath(getenv('INPUT_COVERAGE_BADGE_PATH'));
        $config->setPushBadge(filter_var(getenv('INPUT_PUSH_BADGE'), FILTER_VALIDATE_BOOLEAN));
        $config->setCommitMessage(getenv('INPUT_COMMIT_MESSAGE'));
        $config->setRepoToken(getenv('INPUT_REPO_TOKEN'));

        ConfigValidator::validateConfig($config);

        $this->config = $config;
    }
}