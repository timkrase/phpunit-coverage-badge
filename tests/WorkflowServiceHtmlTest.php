<?php

namespace PhpUnitCoverageBadge;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use PhpUnitCoverageBadge\ReportParser\HtmlReportParser;

class WorkflowServiceHtmlTest extends TestCase
{
    use ConfigTestTrait;

    private WorkflowService $workflowService;
    private MockObject $gitService;

    public function setUp(): void
    {
        $cloverReportParser = new HtmlReportParser();
        $badgeGenerator = new BadgeGenerator();
        $this->gitService = $this->createMock(GitService::class);

        $this->addAllValidConfigSettings();
        putenv('INPUT_COVERAGE_BADGE_PATH=tests/resources/badge.svg');

        $this->workflowService = new WorkflowService($cloverReportParser, $badgeGenerator, $this->gitService);
    }

    /**
     * @runInSeparateProcess
     */
    public function testWithPushHtml(): void
    {
        $this->activatePushBadge();
        $this->addValidHtml();

        $this->gitService->expects($this->exactly(1))->method('pushBadge');

        $this->workflowService->run();

        $shouldBeBadge = file_get_contents(__DIR__ . '/resources/result_badges/91.svg');
        $isBadge = file_get_contents(__DIR__ . '/resources/badge.svg');

        unlink(__DIR__ . '/resources/badge.svg');

        $this->assertEquals($shouldBeBadge, $isBadge);
    }

    /**
     * @runInSeparateProcess
     */
    public function testWithoutPushHtml(): void
    {
        $this->addValidHtml();

        $this->gitService->expects($this->exactly(0))->method('pushBadge');

        $this->workflowService->run();

        $shouldBeBadge = file_get_contents(__DIR__ . '/resources/result_badges/91.svg');
        $isBadge = file_get_contents(__DIR__ . '/resources/badge.svg');

        unlink(__DIR__ . '/resources/badge.svg');

        $this->assertEquals($shouldBeBadge, $isBadge);
    }
}