<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day10Part1 extends AdventBase {

  protected $signature = "year2020:day10part1";
  protected $description = "Advent Of Code 2020 Day 10 Part 1";
  protected $_lines = [];


  public function handle() {
    $this->_lines = $this->_readInput();
    sort($this->_lines);
    $this->_lines[] = end($this->_lines) + 3;

    $diffCounts = [];

    $previousJoltage = 0;
    foreach($this->_lines as $index => $joltage) {
      $diff = $joltage - $previousJoltage;
      if (isset($diffCounts[$diff])) {
        $diffCounts[$diff]++;
      } else {
        $diffCounts[$diff] = 1;
      }
      $previousJoltage = $joltage;
      // echo "$index: $joltage\n";
    }
    // print_r($diffCounts);
    echo "3*1 = " . ($diffCounts[1] * $diffCounts[3]) . "\n";
  }
}
