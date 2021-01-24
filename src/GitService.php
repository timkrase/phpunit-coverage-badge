<?php

namespace PhpUnitCoverageBadge;

class GitService
{
    public function pushBadge(string $email, string $name, string $message, string $repoToken): void
    {
        exec('cd ' . getenv('GITHUB_WORKSPACE'));
        $this->addFile('${INPUT_COVERAGE_BADGE_PATH}');
        $this->addFile('${INPUT_REPORT}');

        $this->setUserEmail($email);
        $this->setUserName($name);

        $this->commit($message);

        $this->push('${GITHUB_ACTOR}', $repoToken, '${GITHUB_REPOSITORY}', '${GITHUB_REF#refs/heads/}');
    }

    private function addFile(string $fileName): void
    {
        exec('git add "' . $fileName . '"');
    }

    private function commit(string $commitMessage): void
    {
        exec('git commit -m "' . $commitMessage . '"');
    }

    private function push(string $user, string $token, string $repo, string $headRef): void
    {
        exec('git push https://"' . $user . '":"' . $token . '"@github.com/"' . $repo . '".git HEAD:"' . $headRef . '";');
    }

    private function setUserEmail(string $email): void
    {
        $this->setConfig('user.email', $email);
    }

    private function setUserName(string $name): void
    {
        $this->setConfig('user.name', $name);
    }

    private function setConfig(string $config, string $newSetting): void
    {
        exec('git config ' . $config . ' "' . $newSetting . '"');
    }
}