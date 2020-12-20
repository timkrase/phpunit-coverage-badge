<?php

namespace PhpUnitCoverageBadge;

class BadgeGenerator
{
    const COLORS = [
        0 => "#e05d44",
        60 => "#fe7d37",
        70 => "#dfb317",
        80 => "#97ca00",
        90 => "#4c1",
    ];

    public function generateBadge(float $codeCoverage, string $badgePath): void
    {
        $template = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '../template.svg');

        $formattedCoverage = $this->formatCoverageNumber($codeCoverage);
        $color = $this->matchCoverageColor($codeCoverage);

        $badge = str_replace('$cov$', $formattedCoverage, $template);
        $badge = str_replace('$color$', $color, $badge);

        $this->saveBadge($badge, $badgePath);
    }

    private function formatCoverageNumber(float $coverage): string
    {
        return (int)$coverage . ' %';
    }

    private function matchCoverageColor(float $coverage): string
    {
        $coverageColor = self::COLORS[0];
        foreach (array_reverse(self::COLORS, true) as $threshold => $color) {
            if ($coverage >= $threshold) {
                $coverageColor = $color;
                break;
            }
        }

        return $coverageColor;
    }

    public function saveBadge(string $badge, string $badgePath): void
    {
        $targetDirectory = dirname($badgePath);

        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        file_put_contents($badgePath, $badge);
    }
}