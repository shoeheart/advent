<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2019;

use App\Console\Commands\Advent\AdventBase;

class Day1Part1 extends AdventBase {

  protected $signature = "year2019:day1part1";
  protected $description = "Advent Of Code 2019 Day 1 Part 1";

  public function handle() {
    $lines = $this->_readInput();
    $sum = 0;
    foreach($lines as $line) {
      $sum += intdiv(intval($line), 3) - 2;
    }
    echo $sum . "\n";
  }
}
