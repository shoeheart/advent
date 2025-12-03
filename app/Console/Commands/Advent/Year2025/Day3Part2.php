<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2025;

use App\Console\AdventBase;

class Day3Part2 extends AdventBase
{
  protected $signature = 'year2025:day3part2';
  protected $description = 'Advent of Code 2025 Day 3 Part 2';

  public function handle() {
    $lines = $this->_readInput();

    $totalJoltage = gmp_init(0);

    foreach ($lines as $bank) {
      if (empty($bank)) continue;

      // Find the maximum joltage for this bank (selecting 12 batteries)
      $maxJoltage = $this->findMaxJoltage($bank, 12);
      echo "Bank: $bank -> Max Joltage: $maxJoltage\n";
      $totalJoltage = gmp_add($totalJoltage, $maxJoltage);
    }

    echo "\nTotal output joltage: " . gmp_strval($totalJoltage) . "\n";

    return parent::SUCCESS;
  }

  private function findMaxJoltage(string $bank, int $count): string {
    $digits = str_split($bank);
    $len = count($digits);

    // We need to select exactly $count batteries (positions) from the bank
    // To maximize the number, we want the largest digits in the leftmost positions

    // Strategy: For each position in the result (left to right),
    // pick the largest available digit that still leaves enough positions
    // for the remaining digits we need to select

    $result = [];
    $startPos = 0;

    for ($resultPos = 0; $resultPos < $count; $resultPos++) {
      // How many more digits do we need after this one?
      $remaining = $count - $resultPos - 1;

      // We need to leave at least $remaining positions after our choice
      $maxSearchPos = $len - $remaining - 1;

      // Find the largest digit in the valid range
      $maxDigit = -1;
      $maxDigitPos = -1;

      for ($i = $startPos; $i <= $maxSearchPos; $i++) {
        if ((int)$digits[$i] > $maxDigit) {
          $maxDigit = (int)$digits[$i];
          $maxDigitPos = $i;
        }
      }

      $result[] = $digits[$maxDigitPos];
      $startPos = $maxDigitPos + 1;
    }

    return implode('', $result);
  }
}
