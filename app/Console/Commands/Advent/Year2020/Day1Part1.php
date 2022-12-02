<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day1Part1 extends AdventBase {

  protected $signature = "year2020:day1part1";
  protected $description = "Advent Of Code 2020 Day 1 Part 1";

  public function handle() {
    $expenses = $this->_readInput();
    for ($i = 0; $i < count($expenses) - 1; $i++) {
      for ($j = $i + 1; $j < count($expenses); $j++) {
        if (($expenses[$i] + $expenses[$j]) == 2020) {
          // echo $expenses[$i] . "\n";
          // echo "*\n";
          // echo $expenses[$j] . "\n";
          // echo "=\n";
          echo ($expenses[$i] * $expenses[$j]) . "\n";
        }
      }
    }
  }
}
