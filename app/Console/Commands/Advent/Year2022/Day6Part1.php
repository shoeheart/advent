<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2022;

use App\Console\AdventBase;

class Day6Part1 extends AdventBase {
  protected $signature = 'year2022:day6part1';
  protected $description = 'Advent of Code 2022 Day 6 Part 1';

  public function handle() {
    $lines = $this->_readInput();
    foreach ($lines as $line) {
      $chars = str_split($line);
      $found = false;
      for ($i = 0; $i < (count($chars) - 3); $i++) {
        if (count(array_unique(array_slice($chars, $i, 4))) == 4) {
          echo "found at " . ($i + 4) . "\n";
          print_r(array_slice($chars, $i, 4));
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
