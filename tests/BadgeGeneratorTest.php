<?php

namespace PhpUnitCoverageBadge;

use PHPUnit\Framework\TestCase;

class BadgeGeneratorTest extends TestCase
{
    const VALID_BADGE = <<<EOT
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="108" height="20" role="img">
    <linearGradient id="s" x2="0" y2="100%">
        <stop offset="0" stop-color="#bbb" stop-opacity=".1"/>
        <stop offset="1" stop-opacity=".1"/>
    </linearGradient>
    <clipPath id="r">
        <rect width="108" height="20" rx="3" fill="#fff"/>
    </clipPath>
    <g clip-path="url(#r)">
        <rect width="63" height="20" fill="#555"/>
        <rect x="63" width="45" height="20" fill="#e05d44"/>
        <rect width="108" height="20" fill="url(#s)"/>
    </g>
    <g fill="#fff" text-anchor="middle" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" text-rendering="geometricPrecision" font-size="110">
        <text aria-hidden="true" x="315" y="150" fill="#010101" fill-opacity=".3" transform="scale(.1)" textLength="530">coverage</text>
        <text x="315" y="140" transform="scale(.1)" fill="#fff" textLength="530">coverage</text>
        <text aria-hidden="true" x="850" y="150" fill="#010101" fill-opacity=".3" transform="scale(.1)" textLength="350">11 %</text>
        <text x="850" y="140" transform="scale(.1)" fill="#fff" textLength="350">11 %</text>
    </g>
</svg>
EOT;

    public function testDirectoryDoesNotExistPreviously(): void
    {
        $badgeGenerator = new BadgeGenerator();

        $badgeGenerator->saveBadge(self::VALID_BADGE, 'tests/this/is/no/directory/0.svg');

        $this->assertFileExists(__DIR__ . '/this/is/no/directory/0.svg');

        if (!file_exists(__DIR__ . '/this/is/no/directory/0.svg')) {
            return;
        }

        unlink(__DIR__ . '/this/is/no/directory/0.svg');
        rmdir(__DIR__ . '/this/is/no/directory');
        rmdir(__DIR__ . '/this/is/no');
        rmdir(__DIR__ . '/this/is');
        rmdir(__DIR__ . '/this');
    }

    public function testOverwritingBadge(): void
    {
        $badgeGenerator = new BadgeGenerator();

        $badgeGenerator->saveBadge(self::VALID_BADGE, 'tests/resources/test_badge.svg');

        $badgePath = __DIR__ . '/resources/test_badge.svg';
        if (!file_exists($badgePath)) {
            return;
        }

        $updatedBadgeContent = file_get_contents($badgePath);

        $this->assertEquals(self::VALID_BADGE, $updatedBadgeContent);

        unlink($badgePath);
        copy(dirname($badgePath) . '/test_badge_backup.svg', $badgePath);
    }

    /**
     *
     * @dataProvider generateBadgeDataProvider
     */
    public function testGenerateBadge(float $codeCoverage, string $badgeName): void
    {
        $badgeGenerator = new BadgeGenerator();

        $tempBadgePath = __DIR__ . '/resources/temp/' . $badgeName;

        $badgeGenerator->generateBadge($codeCoverage, $tempBadgePath);
        $badge = file_get_contents($tempBadgePath);
        $shouldBeBadge = file_get_contents(__DIR__ . '/resources/result_badges/' . $badgeName);

        unlink($tempBadgePath);
        rmdir(dirname($tempBadgePath));

        $this->assertSame($shouldBeBadge, $badge);
    }

    /**
     * @return mixed[]
     */
    public function generateBadgeDataProvider(): array
    {
        return [
            [0.00, '0.svg'],
            [59.99, '59.svg'],
            [60.00, '60.svg'],
            [69.99, '69.svg'],
            [70.00, '70.svg'],
            [79.99, '79.svg'],
            [80.00, '80.svg'],
            [89.99, '89.svg'],
            [90.00, '90.svg'],
            [100.00, '100.svg'],
        ];
    }
}