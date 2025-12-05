<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2025;

use App\Console\AdventBase;

class Day5Part1 extends AdventBase
{
  protected $signature = 'year2025:day5part1';
  protected $description = 'Advent of Code 2025 Day 5 Part 1';

  public function handle() {
    $lines = $this->_readInput();

    $freshRanges = [];
    $ingredientIds = [];
    $parsingRanges = true;

    foreach ($lines as $line) {
      if (empty($line)) {
        $parsingRanges = false;
        continue;
      }

      if ($parsingRanges) {
        // Parse range like "3-5"
        [$start, $end] = explode('-', $line);
        $freshRanges[] = [(int)$start, (int)$end];
      } else {
        // Parse ingredient ID
        $ingredientIds[] = (int)$line;
      }
    }

    $freshCount = 0;

    foreach ($ingredientIds as $id) {
      if ($this->isFresh($id, $freshRanges)) {
        $freshCount++;
      }
    }

    echo "Number of fresh ingredient IDs: $freshCount\n";

    return parent::SUCCESS;
  }

  private function isFresh(int $id, array $ranges): bool {
    foreach ($ranges as [$start, $end]) {
      if ($id >= $start && $id <= $end) {
        return true;
      }
    }
    return false;
  }
}
