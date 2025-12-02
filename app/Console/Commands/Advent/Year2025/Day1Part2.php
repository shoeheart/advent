<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2025;

use App\Console\AdventBase;

class Day1Part2 extends AdventBase
{
  protected $signature = 'year2025:day1part2';
  protected $description = 'Advent of Code 2025 Day 1 Part 2';

  public function handle() {
    $lines = $this->_readInput();

    $position = 50; // Starting position
    $zeroCount = 0; // Count how many times we land on 0

    foreach ($lines as $line) {
      // Parse direction (L or R) and distance
      $direction = $line[0];
      $distance = (int)substr($line, 1);

      // Count how many times we click through 0 during this rotation
      if ($direction === 'L') {
        // Moving left: count = number of times we pass through 0
        // We click on positions: position-1, position-2, ..., position-distance
        if ($position == 0) {
          // Starting at 0, we move to 99, 98, ..., and only hit 0 again after 100 clicks
          $clicksThrough0 = floor($distance / 100);
        } else if ($distance >= $position) {
          // We definitely pass through 0
          $clicksThrough0 = 1 + floor(($distance - $position) / 100);
        } else {
          $clicksThrough0 = 0;
        }
        $zeroCount += $clicksThrough0;
        // Update position
        $position = $position - $distance;
      } else { // R
        // Moving right: count = number of times we pass through 0
        // We pass through 0 when wrapping from 99 to 0
        $clicksThrough0 = floor(($position + $distance) / 100);
        $zeroCount += $clicksThrough0;
        // Update position
        $position = $position + $distance;
      }

      // Wrap around (handle negative and > 99)
      $position = (($position % 100) + 100) % 100;

      echo "After $line: position = $position (zero count: $zeroCount)\n";
    }

    echo "\nPassword: $zeroCount\n";

    return parent::SUCCESS;
  }
}
