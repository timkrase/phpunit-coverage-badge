<?php


use PHPUnit\Framework\TestCase;
use PhpUnitCoverageBadge\Config;
use PhpUnitCoverageBadge\ConfigValidator;

class ConfigValidatorTest extends TestCase
{
    public function testInvalidConfig()
    {
        $config = new Config();
        $config->setPushBadge(true);
        $config->setRepoToken(Config::REPO_TOKEN_DEFAULT);

        $this->expectExceptionMessage(ConfigValidator::NO_REPO_TOKEN_EXCEPTION);

        ConfigValidator::validateConfig($config);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidRepoToken()
    {
        $config = new Config();
        $config->setPushBadge(true);
        $config->setRepoToken('abcde');

        ConfigValidator::validateConfig($config);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testNoPushDefaultRepoToken()
    {
        $config = new Config();
        $config->setPushBadge(false);
        $config->setRepoToken(Config::REPO_TOKEN_DEFAULT);

        ConfigValidator::validateConfig($config);
    }
}