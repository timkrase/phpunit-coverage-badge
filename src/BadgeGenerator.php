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

    private string $badgePath;

    public function __construct(string $badgePath)
    {
        $this->badgePath = $badgePath;
    }

    public function generateBadge(float $codeCoverage)
    {
        $template = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '../template.svg');

        $formattedCoverage = $this->formatCoverageNumber($codeCoverage);
        $color = $this->matchCoverageColor($codeCoverage);

        $badge = str_replace('$cov$', $formattedCoverage, $template);
        $badge = str_replace('$color$', $color, $badge);

        $this->saveBadge($badge);
    }

    private function formatCoverageNumber(float $coverage): string
    {
        return (int)$coverage . ' %';
    }

    private function matchCoverageColor(float $coverage): string
    {
        foreach (array_reverse(self::COLORS, true) as $threshold => $color) {
            if ($coverage >= $threshold) {
                return $color;
            }
        }
    }

    public function saveBadge(string $badge)
    {
        $badgeTargetPath = __DIR__ . DIRECTORY_SEPARATOR . '../' . $this->badgePath;
        $targetDirectory = dirname($badgeTargetPath);

        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        file_put_contents($badgeTargetPath, $badge);
    }
}