<?php declare(strict_types=1);

require('../vendor/autoload.php');

$cloverFile = getenv('INPUT_CLOVER_REPORT');
$badgePath = getenv('INPUT_COVERAGE_BADGE_PATH');
$repoToken = getenv('INPUT_REPO_TOKEN') ?? null;
$commitMessage = getenv('INPUT_COMMIT_MESSAGE');

if ($repoToken === null) {
    throw new Exception('No Github Repo token supplied. Please add it to your workflow.');
}

$coverageParser = new \PhpUnitCoverageBadge\CoverageReportParser($cloverFile);
$codeCoverage = $coverageParser->getCodeCoverage();

$badgeGenerator = new \PhpUnitCoverageBadge\BadgeGenerator($badgePath);
$badgeGenerator->generateBadge($codeCoverage);

exec(dirname(__FILE__) . '/commit_push_badge.sh');