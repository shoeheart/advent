<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2021;

use App\Console\AdventBase;

class Day7Part1 extends AdventBase {

  protected $signature = "year2021:day7part1";
  protected $description = "Advent Of Code 2021 Day 7 Part 1";


  public function handle() {
    $crabs = explode(',',$this->_readInput()[0]);
    $crabCounts = [];
    foreach($crabs as $crab) {
      if (!isset($crabCounts[$crab])) {
        $crabCounts[$crab] = 0;
      }
      $crabCounts[$crab]++;
    }
    echo print_r($crabCounts, true) . "\n";
    $minX = min(array_keys($crabCounts));
    $maxX = max(array_keys($crabCounts));

    /* calculate cost to most all crabs to each position */
    $costs = [];
    for ($x = $minX; $x <= $maxX; $x++) {
      $costs[$x] = 0;
      foreach($crabCounts as $position => $count) {
        $costs[$x] += abs($position - $x) * $count;
      }
      // echo print_r($costs, true) . "\n";
    }
    $minPosition = array_search(min($costs), $costs);
    echo "minimum fuel use of " . $costs[$minPosition] . " at position $minPosition\n";
  }
}
