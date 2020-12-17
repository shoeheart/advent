<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\Commands\Advent\AdventBase;

class Day18Part1 extends AdventBase {

  protected $signature = "year2020:day18part1";
  protected $description = "Advent Of Code 2020 Day 18 Part 1";

  public function handle() {
    $lines = $this->_readInput();
  }
}
