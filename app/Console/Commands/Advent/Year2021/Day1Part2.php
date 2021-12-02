<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2021;

use App\Console\Commands\Advent\AdventBase;

class Day1Part2 extends AdventBase {

  protected $signature = "year2021:day1part2";
  protected $description = "Advent Of Code 2021 Day 1 Part 2";

  public function handle() {
    $lines = $this->_readInput();
    $increases = 0;
    $previous =
      array_sum(
        array_slice(
          $lines,
          0,
          3,
          false
        )
      );
    for ($i = 3; $i < count($lines); $i++) {
      $current = array_sum(
        array_slice(
          $lines,
          $i - 2,
          3,
          false
        )
      );
      if ($current > $previous) {
        $increases++;
      }
      $previous = $current;
    }
    echo "$increases increases\n";
  }
}
