<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2022;

use App\Console\AdventBase;

class Day6Part2 extends AdventBase
{
  protected $signature = 'year2022:day6part2';
  protected $description = 'Advent of Code 2022 Day 6 Part 2';

  public function handle() {
    $lines = $this->_readInput();
    foreach ($lines as $line) {
      $chars = str_split($line);
      $found = false;
      for ($i = 0; $i < (count($chars) - 13); $i++) {
        if (count(array_unique(array_slice($chars, $i, 14))) == 14) {
          echo "found at " . ($i + 14) . "\n";
          print_r(array_slice($chars, $i, 14));
          $found = true;
          break;
        }
      }
      if (! $found) {
        echo "oops\n";
      }
    }
    return parent::SUCCESS;
  }
}
