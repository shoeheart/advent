<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2025;

use App\Console\AdventBase;

class Day2Part1 extends AdventBase
{
  protected $signature = 'year2025:day2part1';
  protected $description = 'Advent of Code 2025 Day 2 Part 1';

  public function handle() {
    $lines = $this->_readInput();

    // Parse the input - it's all on one line, comma-separated
    $input = implode('', $lines); // Join all lines
    $ranges = explode(',', $input);

    $totalSum = 0;

    foreach ($ranges as $range) {
      $range = trim($range);
      if (empty($range)) continue;

      // Parse the range "start-end"
      $parts = explode('-', $range);
      $start = (int)$parts[0];
      $end = (int)$parts[1];

      echo "Checking range $start-$end...\n";

      // Check each number in the range
      for ($id = $start; $id <= $end; $id++) {
        if ($this->isInvalid($id)) {
          $totalSum += $id;
          echo "  Invalid ID found: $id\n";
        }
      }
    }

    echo "\nTotal sum: $totalSum\n";

    return parent::SUCCESS;
  }

  private function isInvalid($id) {
    $str = (string)$id;
    $len = strlen($str);

    // Must be even length to be a pattern repeated twice
    if ($len % 2 !== 0) {
      return false;
    }

    $half = $len / 2;
    $firstHalf = substr($str, 0, $half);
    $secondHalf = substr($str, $half);

    return $firstHalf === $secondHalf;
  }
}
