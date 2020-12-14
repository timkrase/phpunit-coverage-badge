<?php


namespace PhpUnitCoverageBadge;

use Assert\Assertion;

class ConfigValidator
{
    const NO_REPO_TOKEN_EXCEPTION = 'Pushing the badge was activated but no Github Repo token has been supplied. Please add it to your workflow.';

    public static function validateConfig(Config $config): void
    {
        $pushBadge = $config->isPushBadge();
        $repoToken = $config->getRepoToken();

        if ($pushBadge) {
            Assertion::notEq($repoToken, Config::REPO_TOKEN_DEFAULT, self::NO_REPO_TOKEN_EXCEPTION);
        }
    }
}