<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2021;

use App\Console\Commands\Advent\AdventBase;

class Day1Part1 extends AdventBase {

  protected $signature = "year2021:day1part1";
  protected $description = "Advent Of Code 2021 Day 1 Part 1";

  public function handle() {
    $lines = $this->_readInput();
    $increases = 0;
    $previous = $lines[0];
    for ($i = 1; $i < count($lines); $i++) {
      if ($lines[$i] > $previous) {
        $increases++;
      }
      $previous = $lines[$i];
    }
    echo "$increases increases\n";
  }
}
