<?php


namespace PhpUnitCoverageBadge;

use Assert\Assertion;
use Assert\AssertionFailedException;

class Config
{
    const REPO_TOKEN_DEFAULT = 'NOT_SUPPLIED';

    private string $cloverFilePath;
    private string $badgePath;
    private bool $pushBadge;
    private string $repoToken;
    private string $commitMessage;

    /**
     * @return string
     */
    public function getCloverFilePath(): string
    {
        return $this->cloverFilePath;
    }

    /**
     * @param string $cloverFilePath
     * @throws AssertionFailedException
     */
    public function setCloverFilePath(string $cloverFilePath): void
    {
        Assertion::file($cloverFilePath);

        $this->cloverFilePath = $cloverFilePath;
    }

    /**
     * @return string
     */
    public function getBadgePath(): string
    {
        return $this->badgePath;
    }

    /**
     * @param string $badgePath
     */
    public function setBadgePath(string $badgePath): void
    {
        $this->badgePath = $badgePath;
    }

    /**
     * @return bool
     */
    public function isPushBadge(): bool
    {
        return $this->pushBadge;
    }

    /**
     * @param bool $pushBadge
     */
    public function setPushBadge(bool $pushBadge): void
    {
        $this->pushBadge = $pushBadge;
    }

    /**
     * @return string
     */
    public function getRepoToken(): string
    {
        return $this->repoToken;
    }

    /**
     * @param string $repoToken
     */
    public function setRepoToken(string $repoToken): void
    {
        $this->repoToken = $repoToken;
    }

    /**
     * @return string
     */
    public function getCommitMessage(): string
    {
        return $this->commitMessage;
    }

    /**
     * @param string $commitMessage
     */
    public function setCommitMessage(string $commitMessage): void
    {
        $this->commitMessage = $commitMessage;
    }
}