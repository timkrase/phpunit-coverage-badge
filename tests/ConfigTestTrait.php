<?php


namespace PhpUnitCoverageBadge;


trait ConfigTestTrait
{
    public function addAllValidConfigSettings(): void
    {
        $this->addValidClover();
        $this->addValidBadgePath();
        $this->addValidRepoToken();
        $this->addValidCommitMessage();
        $this->addDefaultCommitEmail();
        $this->addDefaultCommitName();
    }

    public function addValidClover(): void
    {
        putenv('INPUT_REPORT=tests/resources/clover_valid_29.xml');
    }

    public function addValidBadgePath(): void
    {
        putenv('INPUT_COVERAGE_BADGE_PATH=badge.svg');
    }

    public function addValidRepoToken(): void
    {
        putenv('INPUT_REPO_TOKEN=testtesttest');
    }

    public function addValidCommitMessage(): void
    {
        putenv('INPUT_COMMIT_MESSAGE=Default Commit Message');
    }

    public function addDefaultRepoToken(): void
    {
        putenv('INPUT_REPO_TOKEN=' . Config::REPO_TOKEN_DEFAULT);
    }

    public function addDefaultCommitEmail(): void
    {
        putenv('INPUT_COMMIT_EMAIL=41898282+github-actions[bot]@users.noreply.github.com');
    }

    public function addDefaultCommitName(): void
    {
        putenv('INPUT_COMMIT_NAME=Github Actions Bot');
    }
}