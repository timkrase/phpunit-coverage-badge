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
        $this->saveBadge(
            $this->formatCoverageNumber($codeCoverage),
            $color = $this->matchCoverageColor($codeCoverage)
        );
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

    public function saveBadge(string $formattedCoverage, string $color)
    {
        $template = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '../template.svg');

        $badge = str_replace('$cov$', $formattedCoverage, $template);
        $badge = str_replace('$color$', $color, $badge);

        file_put_contents($this->badgePath, $badge);
    }
}