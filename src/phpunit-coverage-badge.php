<?php declare(strict_types=1);

require(__DIR__ . DIRECTORY_SEPARATOR . '../vendor/autoload.php');

$cloverFile = getenv('INPUT_CLOVER_REPORT');
$badgePath = getenv('INPUT_COVERAGE_BADGE_PATH');
$pushBadge = getenv('INPUT_PUSH_BADGE');
$repoToken = getenv('INPUT_REPO_TOKEN');
$commitMessage = getenv('INPUT_COMMIT_MESSAGE');

if (!$cloverFile) {
    return;
}

if (!$repoToken) {
    throw new Exception('No Github Repo token supplied. Please add it to your workflow.');
}

$coverageParser = new \PhpUnitCoverageBadge\CoverageReportParser($cloverFile);
$codeCoverage = $coverageParser->getCodeCoverage();

$badgeGenerator = new \PhpUnitCoverageBadge\BadgeGenerator($badgePath);
$badgeGenerator->generateBadge($codeCoverage);

if ($pushBadge) {
    exec('chmod +x ' . __DIR__ . '/commit_push_badge.sh');
    exec(__DIR__ . '/commit_push_badge.sh');
}
