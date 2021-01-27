<?php

namespace PhpUnitCoverageBadge;

class GitService
{
    public function pushBadge(
        string $email,
        string $name,
        string $message,
        string $repoToken,
        string $githubWorkspace
    ): void {
        $this->addFile('${INPUT_COVERAGE_BADGE_PATH}', $githubWorkspace);
        $this->addFile('${INPUT_REPORT}', $githubWorkspace);

        $this->setUserEmail($email, $githubWorkspace);
        $this->setUserName($name, $githubWorkspace);

        $this->commit($message, $githubWorkspace);

        $this->push(
            '${GITHUB_ACTOR}',
            $repoToken,
            '${GITHUB_REPOSITORY}',
            '${GITHUB_REF#refs/heads/}',
            $githubWorkspace
        );
    }

    private function addFile(string $fileName, string $githubWorkspace): void
    {
        exec('cd ' . $githubWorkspace . ' && git add "' . $fileName . '"');
    }

    private function commit(string $commitMessage, string $githubWorkspace): void
    {
        exec('cd ' . $githubWorkspace . ' /github/workspace && git commit -m "' . $commitMessage . '"');
    }

    private function push(string $user, string $token, string $repo, string $headRef, string $githubWorkspace): void
    {
        exec('cd ' . $githubWorkspace . ' && git push https://"' . $user . '":"' . $token . '"@github.com/"' . $repo . '".git HEAD:"' . $headRef . '";');
    }

    private function setUserEmail(string $email, string $githubWorkspace): void
    {
        $this->setConfig('user.email', $email, $githubWorkspace);
    }

    private function setUserName(string $name, string $githubWorkspace): void
    {
        $this->setConfig('user.name', $name, $githubWorkspace);
    }

    private function setConfig(string $config, string $newSetting, string $githubWorkspace): void
    {
        exec('cd ' . $githubWorkspace . ' && git config ' . $config . ' "' . $newSetting . '"');
    }
}