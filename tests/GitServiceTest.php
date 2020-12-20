<?php

namespace PhpUnitCoverageBadge;

use phpmock\phpunit\PHPMock;
use PHPUnit\Framework\TestCase;

class GitServiceTest extends TestCase
{
    use PHPMock;

    public function testPushBadge(): void
    {
        $exec = $this->getFunctionMock(__NAMESPACE__, 'exec');
        $exec->expects($this->exactly(6))->withConsecutive(
            ['git add "${INPUT_COVERAGE_BADGE_PATH}"'],
            ['git add "${INPUT_CLOVER_REPORT}"'],
            ['git config user.email "${INPUT_COMMIT_EMAIL}"'],
            ['git config user.name "${INPUT_COMMIT_NAME}"'],
            ['git commit -m "${INPUT_COMMIT_MESSAGE}"'],
            ['git push https://"${GITHUB_ACTOR}":"${INPUT_REPO_TOKEN}"@github.com/"${GITHUB_REPOSITORY}".git HEAD:"${GITHUB_REF#refs/heads/}";']
        );

        $gitService = new GitService();

        $gitService->pushBadge('${INPUT_COMMIT_EMAIL}', '${INPUT_COMMIT_NAME}', '${INPUT_COMMIT_MESSAGE}', '${INPUT_REPO_TOKEN}');
    }
}