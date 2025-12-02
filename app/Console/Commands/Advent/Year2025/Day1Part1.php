<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2025;

use App\Console\AdventBase;

class Day1Part1 extends AdventBase
{
  protected $signature = 'year2025:day1part1';
  protected $description = 'Advent of Code 2025 Day 1 Part 1';

  public function handle() {
    $lines = $this->_readInput();

    $position = 50; // Starting position
    $zeroCount = 0; // Count how many times we land on 0

    foreach ($lines as $line) {
      // Parse direction (L or R) and distance
      $direction = $line[0];
      $distance = (int)substr($line, 1);

      // Apply rotation
      if ($direction === 'L') {
        $position = $position - $distance;
      } else { // R
        $position = $position + $distance;
      }

      // Wrap around (handle negative and > 99)
      $position = (($position % 100) + 100) % 100;

      // Check if we landed on 0
      if ($position === 0) {
        $zeroCount++;
      }

      echo "After $line: position = $position (zero count: $zeroCount)\n";
    }

    echo "\nPassword: $zeroCount\n";

    return parent::SUCCESS;
  }
}
