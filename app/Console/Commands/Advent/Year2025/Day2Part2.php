<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2025;

use App\Console\AdventBase;

class Day2Part2 extends AdventBase
{
  protected $signature = 'year2025:day2part2';
  protected $description = 'Advent of Code 2025 Day 2 Part 2';

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

    // Try all possible pattern lengths (from 1 to len/2)
    // The pattern must repeat at least twice
    for ($patternLen = 1; $patternLen <= $len / 2; $patternLen++) {
      // Check if the length is divisible by pattern length
      if ($len % $patternLen !== 0) {
        continue;
      }

      $pattern = substr($str, 0, $patternLen);
      $isRepeating = true;

      // Check if the entire string is this pattern repeated
      for ($i = $patternLen; $i < $len; $i += $patternLen) {
        if (substr($str, $i, $patternLen) !== $pattern) {
          $isRepeating = false;
          break;
        }
      }

      if ($isRepeating) {
        return true;
      }
    }

    return false;
  }
}
