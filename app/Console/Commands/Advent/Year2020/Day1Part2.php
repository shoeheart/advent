<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day1Part2 extends AdventBase {

  protected $signature = "year2020:day1part2";
  protected $description = "Advent Of Code 2020 Day 1 Part 2";

  public function handle() {
    $expenses = $this->_readInput();
    for ($i = 0; $i < count($expenses) - 2; $i++) {
      for ($j = $i + 1; $j < count($expenses) - 1; $j++) {
        for ($k = $j + 1; $k < count($expenses); $k++) {
          if (($expenses[$i] + $expenses[$j] + $expenses[$k]) == 2020) {
            echo $expenses[$i] . "\n";
            echo "*\n";
            echo $expenses[$j] . "\n";
            echo "*\n";
            echo $expenses[$k] . "\n";
            echo "=\n";
            echo ($expenses[$i] * $expenses[$j] * $expenses[$k]) . "\n";
          }
        }
      }
    }
  }
}
