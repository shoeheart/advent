<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2025;

use App\Console\AdventBase;

class Day3Part1 extends AdventBase
{
  protected $signature = 'year2025:day3part1';
  protected $description = 'Advent of Code 2025 Day 3 Part 1';

  public function handle() {
    $lines = $this->_readInput();

    $totalJoltage = 0;

    foreach ($lines as $bank) {
      if (empty($bank)) continue;

      // Find the maximum joltage for this bank
      $maxJoltage = $this->findMaxJoltage($bank);
      echo "Bank: $bank -> Max Joltage: $maxJoltage\n";
      $totalJoltage += $maxJoltage;
    }

    echo "\nTotal output joltage: $totalJoltage\n";

    return parent::SUCCESS;
  }

  private function findMaxJoltage(string $bank): int {
    $digits = str_split($bank);
    $len = count($digits);

    // We need to pick any two batteries (at any positions i < j)
    // to form a 2-digit number where the first digit comes before the second
    $maxJoltage = 0;

    for ($i = 0; $i < $len - 1; $i++) {
      for ($j = $i + 1; $j < $len; $j++) {
        $joltage = (int)($digits[$i] . $digits[$j]);
        if ($joltage > $maxJoltage) {
          $maxJoltage = $joltage;
        }
      }
    }

    return $maxJoltage;
  }
}
