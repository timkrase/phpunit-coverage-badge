<?php

namespace PhpUnitCoverageBadge;

use Assert\Assertion;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    use ConfigTestTrait;

    /**
     * @runInSeparateProcess
     */
    public function testNoCloverFile(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(Assertion::INVALID_STRING);

        new Config();
    }

    /**
     * @runInSeparateProcess
     */
    public function testWrongCloverFile(): void
    {
        putenv('INPUT_REPORT=tests/resources/notexistingcloverfile.xml');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(Assertion::INVALID_FILE);

        new Config();
    }

    /**
     * @runInSeparateProcess
     */
    public function testNoBadgePath(): void
    {
        $this->addValidClover();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(Assertion::INVALID_STRING);

        new Config();
    }

    /**
     * @runInSeparateProcess
     */
    public function testDefaultPushBadge(): void
    {
        $this->addValidClover();
        $this->addValidBadgePath();
        $this->addValidRepoToken();
        $this->addValidCommitMessage();
        $this->addDefaultCommitEmail();
        $this->addDefaultCommitName();

        $config = new Config();

        $this->assertSame(false, $config->isPushBadge());
    }

    /**
     * @runInSeparateProcess
     */
    public function testEnabledPushMessageNoRepoToken(): void
    {
        $this->addValidClover();
        $this->addValidBadgePath();
        $this->addValidCommitMessage();
        $this->addDefaultRepoToken();
        $this->addDefaultCommitEmail();
        $this->addDefaultCommitName();

        putenv('INPUT_PUSH_BADGE=true');

        $this->expectExceptionMessage(Config::NO_REPO_TOKEN_EXCEPTION);

        new Config();
    }

    /**
     * @runInSeparateProcess
     */
    public function testNoRepoToken(): void
    {
        $this->addValidClover();
        $this->addValidBadgePath();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(Assertion::INVALID_STRING);

        new Config();
    }

    /**
     * @runInSeparateProcess
     */
    public function testNoCommitMessage(): void
    {
        $this->addValidClover();
        $this->addValidBadgePath();
        $this->addValidRepoToken();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(Assertion::INVALID_STRING);

        new Config();
    }

    /**
     * @runInSeparateProcess
     */
    public function testAllValidNoPush(): void
    {
        $this->addAllValidConfigSettings();
        putenv('INPUT_PUSH_BADGE=true');

        $config = new Config();

        $this->assertEquals(realpath(__DIR__ . '/../tests/resources/clover_valid_29.xml'), realpath($config->getReportFilePath()));
        $this->assertEquals(realpath(__DIR__ . '/../' . 'badge.svg'), realpath($config->getBadgePath()));
        $this->assertEquals('testtesttest', $config->getRepoToken());
        $this->assertEquals('Default Commit Message', $config->getCommitMessage());
        $this->assertEquals('41898282+github-actions[bot]@users.noreply.github.com', $config->getCommitEmail());
        $this->assertEquals('Github Actions Bot', $config->getCommitName());
        $this->assertEquals(true, $config->getPushBadge());
    }

    /**
     * @runInSeparateProcess
     */
    public function testAllValidWithPush(): void
    {
        $this->addAllValidConfigSettings();
        $config = new Config();

        $this->assertEquals(realpath(__DIR__ . '/../tests/resources/clover_valid_29.xml'), realpath($config->getReportFilePath()));
        $this->assertEquals(realpath(__DIR__ . '/../' . 'badge.svg'), realpath($config->getBadgePath()));
        $this->assertEquals('testtesttest', $config->getRepoToken());
        $this->assertEquals('Default Commit Message', $config->getCommitMessage());
        $this->assertEquals('41898282+github-actions[bot]@users.noreply.github.com', $config->getCommitEmail());
        $this->assertEquals('Github Actions Bot', $config->getCommitName());
        $this->assertEquals(false, $config->getPushBadge());
    }
}