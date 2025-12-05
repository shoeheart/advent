<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2025;

use App\Console\AdventBase;

class Day5Part2 extends AdventBase
{
  protected $signature = 'year2025:day5part2';
  protected $description = 'Advent of Code 2025 Day 5 Part 2';

  public function handle() {
    $lines = $this->_readInput();

    $freshRanges = [];

    foreach ($lines as $line) {
      if (empty($line)) {
        // Stop parsing at the blank line
        break;
      }

      // Parse range like "3-5"
      [$start, $end] = explode('-', $line);
      $freshRanges[] = [(int)$start, (int)$end];
    }

    // Merge overlapping ranges
    $mergedRanges = $this->mergeRanges($freshRanges);

    // Count total IDs in all merged ranges
    $totalFreshIds = 0;
    foreach ($mergedRanges as [$start, $end]) {
      $totalFreshIds += ($end - $start + 1);
    }

    echo "Total fresh ingredient IDs: $totalFreshIds\n";

    return parent::SUCCESS;
  }

  private function mergeRanges(array $ranges): array {
    if (empty($ranges)) {
      return [];
    }

    // Sort ranges by start position
    usort($ranges, function($a, $b) {
      return $a[0] <=> $b[0];
    });

    $merged = [$ranges[0]];

    for ($i = 1; $i < count($ranges); $i++) {
      $current = $ranges[$i];
      $lastMerged = &$merged[count($merged) - 1];

      // Check if current range overlaps or is adjacent to the last merged range
      if ($current[0] <= $lastMerged[1] + 1) {
        // Merge by extending the end of the last merged range
        $lastMerged[1] = max($lastMerged[1], $current[1]);
      } else {
        // No overlap, add as a new range
        $merged[] = $current;
      }
    }

    return $merged;
  }
}
