<?php

namespace PhpUnitCoverageBadge;

class GitService
{
    public function pushBadge(string $email, string $name, string $message, string $repoToken): void
    {
        /**
         * @psalm-suppress PossiblyFalseOperand
         */
        exec('cd /github/workspace');
        exec('ls -l /github/workspace', $output);
        exec('ls -l', $output2);
        /**
         * @psalm-suppress ForbiddenCode
         * @psalm-suppress PossiblyFalseOperand
         */
        var_dump(getenv('GITHUB_WORKSPACE'));

        /**
         * @psalm-suppress ForbiddenCode
         * @psalm-suppress PossiblyFalseOperand
         */
        var_dump($output);
        /**
         * @psalm-suppress ForbiddenCode
         * @psalm-suppress PossiblyFalseOperand
         */
        var_dump($output2);

        $this->addFile('${INPUT_COVERAGE_BADGE_PATH}');
        $this->addFile('${INPUT_REPORT}');

        $this->setUserEmail($email);
        $this->setUserName($name);

        $this->commit($message);

        $this->push('${GITHUB_ACTOR}', $repoToken, '${GITHUB_REPOSITORY}', '${GITHUB_REF#refs/heads/}');
    }

    private function addFile(string $fileName): void
    {
        exec('cd /github/workspace && git add "' . $fileName . '"');
    }

    private function commit(string $commitMessage): void
    {
        exec('cd /github/workspace && git commit -m "' . $commitMessage . '"');
    }

    private function push(string $user, string $token, string $repo, string $headRef): void
    {
        exec('cd /github/workspace && git push https://"' . $user . '":"' . $token . '"@github.com/"' . $repo . '".git HEAD:"' . $headRef . '";');
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
        exec('cd /github/workspace && git config ' . $config . ' "' . $newSetting . '"');
    }
}