<?php


namespace PhpUnitCoverageBadge;

use Assert\Assertion;

class Config
{
    const REPO_TOKEN_DEFAULT = 'NOT_SUPPLIED';
    const NO_REPO_TOKEN_EXCEPTION = 'Pushing the badge was activated but no Github Repo token has been supplied. Please add it to your workflow.';

    private string $cloverFilePath;
    private string $badgePath;
    private bool $pushBadge;
    private string $repoToken;
    private string $commitMessage;

    public function __construct()
    {
        $cloverFilePath = getenv('INPUT_CLOVER_REPORT');
        Assertion::string($cloverFilePath);
        Assertion::file($cloverFilePath);
        $this->cloverFilePath = $cloverFilePath;

        $badgePath = getenv('INPUT_COVERAGE_BADGE_PATH');
        Assertion::string($badgePath);
        $this->badgePath = $badgePath;

        $pushBadge = filter_var(getenv('INPUT_PUSH_BADGE'), FILTER_VALIDATE_BOOLEAN);
        $this->pushBadge = $pushBadge;

        $repoToken = getenv('INPUT_REPO_TOKEN');
        Assertion::string($repoToken);
        $this->repoToken = $repoToken;

        $commitMessage = getenv('INPUT_COMMIT_MESSAGE');
        Assertion::string($commitMessage);
        $this->commitMessage = $commitMessage;

        $this->runAdditionalValidation();
    }

    private function runAdditionalValidation(): void
    {
        $pushBadge = $this->isPushBadge();
        $repoToken = $this->getRepoToken();

        if (!$pushBadge) {
            return;
        }

        Assertion::notEq($repoToken, Config::REPO_TOKEN_DEFAULT, self::NO_REPO_TOKEN_EXCEPTION);
    }

    /**
     */
    public function getCloverFilePath(): string
    {
        return $this->cloverFilePath;
    }

    /**
     */
    public function getBadgePath(): string
    {
        return $this->badgePath;
    }

    /**
     */
    public function isPushBadge(): bool
    {
        return $this->pushBadge;
    }

    /**
     */
    public function getRepoToken(): string
    {
        return $this->repoToken;
    }

    /**
     */
    public function getCommitMessage(): string
    {
        return $this->commitMessage;
    }
}