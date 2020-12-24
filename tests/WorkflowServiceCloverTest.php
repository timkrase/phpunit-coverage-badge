<?php

namespace PhpUnitCoverageBadge;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use PhpUnitCoverageBadge\ReportParser\CloverReportParser;

class WorkflowServiceCloverTest extends TestCase
{
    use ConfigTestTrait;

    private WorkflowService $workflowService;
    private MockObject $gitService;

    public function setUp(): void
    {
        $cloverReportParser = new CloverReportParser();
        $badgeGenerator = new BadgeGenerator();
        $this->gitService = $this->createMock(GitService::class);

        $this->addAllValidConfigSettings();
        putenv('INPUT_COVERAGE_BADGE_PATH=tests/resources/badge.svg');

        $this->workflowService = new WorkflowService($cloverReportParser, $badgeGenerator, $this->gitService);
    }

    /**
     * @runInSeparateProcess
     */
    public function testWithPushClover(): void
    {
        $this->activatePushBadge();

        $this->gitService->expects($this->exactly(1))->method('pushBadge');

        $this->workflowService->run();

        $shouldBeBadge = file_get_contents(__DIR__ . '/resources/result_badges/29.svg');
        $isBadge = file_get_contents(__DIR__ . '/resources/badge.svg');

        unlink(__DIR__ . '/resources/badge.svg');

        $this->assertEquals($shouldBeBadge, $isBadge);
    }

    /**
     * @runInSeparateProcess
     */
    public function testWithoutPushClover(): void
    {
        $this->gitService->expects($this->exactly(0))->method('pushBadge');

        $this->workflowService->run();

        $shouldBeBadge = file_get_contents(__DIR__ . '/resources/result_badges/29.svg');
        $isBadge = file_get_contents(__DIR__ . '/resources/badge.svg');

        unlink(__DIR__ . '/resources/badge.svg');

        $this->assertEquals($shouldBeBadge, $isBadge);
    }

}