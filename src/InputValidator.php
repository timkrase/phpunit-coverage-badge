<?php


namespace PhpUnitCoverageBadge;


class InputValidator
{
    const REPO_TOKEN_DEFAULT = 'NOT_SUPPLIED';

    public function validateInputs()
    {
        $pushBadge = filter_var(getenv('INPUT_PUSH_BADGE'), FILTER_VALIDATE_BOOLEAN);
        $repoToken = getenv('INPUT_REPO_TOKEN');

        if ($pushBadge && $repoToken === self::REPO_TOKEN_DEFAULT) {
            throw new \InvalidArgumentException('Pushing the badge was activated but no Github Repo token has been supplied. Please add it to your workflow.');
        }
    }
}