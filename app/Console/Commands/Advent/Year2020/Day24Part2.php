<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\Commands\Advent\AdventBase;

class Day24Part2 extends AdventBase {

  protected $signature = "year2020:day24part2";
  protected $description = "Advent Of Code 2020 Day 24 Part 2";

  public function handle() {
    $lines = $this->_readInput();
  }
}