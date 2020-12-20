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
    private string $commitEmail;
    private string $commitName;

    public function __construct()
    {
        $cloverFilePath = getenv('INPUT_CLOVER_REPORT', true);
        Assertion::string($cloverFilePath);
        $cloverFilePath = __DIR__ . "/../" . $cloverFilePath;
        Assertion::file($cloverFilePath);
        $this->cloverFilePath = $cloverFilePath;

        $badgePath = getenv('INPUT_COVERAGE_BADGE_PATH', true);
        Assertion::string($badgePath);
        $badgePath = __DIR__ . "/../" . $badgePath;
        $this->badgePath = $badgePath;

        $pushBadge = filter_var(getenv('INPUT_PUSH_BADGE', true), FILTER_VALIDATE_BOOLEAN);
        $this->pushBadge = $pushBadge;

        $repoToken = getenv('INPUT_REPO_TOKEN', true);
        Assertion::string($repoToken);
        $this->repoToken = $repoToken;

        $commitMessage = getenv('INPUT_COMMIT_MESSAGE', true);
        Assertion::string($commitMessage);
        $this->commitMessage = $commitMessage;

        $commitEmail = getenv('INPUT_COMMIT_EMAIL', true);
        Assertion::string($commitEmail);
        $this->commitEmail = $commitEmail;

        $commitName = getenv('INPUT_COMMIT_NAME', true);
        Assertion::string($commitName);
        $this->commitName = $commitName;

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

    public function getCloverFilePath(): string
    {
        return $this->cloverFilePath;
    }

    public function getBadgePath(): string
    {
        return $this->badgePath;
    }

    public function isPushBadge(): bool
    {
        return $this->pushBadge;
    }

    public function getRepoToken(): string
    {
        return $this->repoToken;
    }

    public function getCommitMessage(): string
    {
        return $this->commitMessage;
    }

    public function getPushBadge(): bool
    {
        return $this->pushBadge;
    }

    public function getCommitEmail(): string
    {
        return $this->commitEmail;
    }

    public function getCommitName(): string
    {
        return $this->commitName;
    }
}