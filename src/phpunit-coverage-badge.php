<?php declare(strict_types=1);

require(__DIR__ . DIRECTORY_SEPARATOR . '../vendor/autoload.php');

$cloverFile = getenv('INPUT_CLOVER_REPORT');
$badgePath = getenv('INPUT_COVERAGE_BADGE_PATH');
$pushBadge = filter_var(getenv('INPUT_PUSH_BADGE'), FILTER_VALIDATE_BOOLEAN);
$repoToken = getenv('INPUT_REPO_TOKEN');
$commitMessage = getenv('INPUT_COMMIT_MESSAGE');

if (!$cloverFile) {
    return;
}

if ($pushBadge && $repoToken === 'NOT_SUPPLIED') {
    throw new Exception('Pushing the badge was activated but no Github Repo token has been supplied. Please add it to your workflow.');
}

$coverageParser = new \PhpUnitCoverageBadge\CoverageReportParser($cloverFile);
$codeCoverage = $coverageParser->getCodeCoverage();

$badgeGenerator = new \PhpUnitCoverageBadge\BadgeGenerator($badgePath);
$badgeGenerator->generateBadge($codeCoverage);

if ($pushBadge) {
    exec('chmod +x ' . __DIR__ . '/commit_push_badge.sh');
    exec(__DIR__ . '/commit_push_badge.sh');
}
