<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\Commands\Advent\AdventBase;

class Day20Part2 extends AdventBase {

  protected $signature = "year2020:day20part2";
  protected $description = "Advent Of Code 2020 Day 20 Part 2";

  public function handle() {
    $lines = $this->_readInput();
  }
}
