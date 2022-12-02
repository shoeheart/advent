<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2021;

use App\Console\AdventBase;

class Day9Part1 extends AdventBase {

  protected $signature = "year2021:day9part1";
  protected $description = "Advent Of Code 2021 Day 9 Part 1";


  public function handle() {
    $lines = $this->_readInput();
    $boards = array();
    // $calls = explode(',', $lines[0]);
    // echo "calls = " . implode(',', $calls) . "\n";
    $i = 2;
    while ($i <= (count($lines) - 2)) {
      for ($j = $i; $j < $i + 5; $j++) {
      }
    }
  }
}
