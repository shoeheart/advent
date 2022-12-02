<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2021;

use App\Console\AdventBase;

class Day6Part2 extends AdventBase {

  protected $signature = "year2021:day6part2";
  protected $description = "Advent Of Code 2021 Day 6 Part 2";


  public function handle() {
    $fish = explode(',',$this->_readInput()[0]);
    $fishCounts = array(0, 0, 0, 0, 0, 0, 0, 0, 0);
    foreach($fish as $f) {
      $fishCounts[$f]++;
    }
    echo print_r($fishCounts, true) . "\n";
    for ($d = 1; $d <= 256; $d++) {
      $zeroes = array_shift($fishCounts);
      echo "zeroes: $zeroes\n";
      echo print_r($fishCounts, true) . "\n";
      $fishCounts[6] += $zeroes;
      $fishCounts[] = $zeroes;
      echo print_r($fishCounts, true) . "\n";
    }
    echo array_sum($fishCounts) . "\n";
  }
}
