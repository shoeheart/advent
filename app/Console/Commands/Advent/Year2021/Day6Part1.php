<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2021;

use App\Console\Commands\Advent\AdventBase;

class Day6Part1 extends AdventBase {

  protected $signature = "year2021:day6part1";
  protected $description = "Advent Of Code 2021 Day 6 Part 1";


  public function handle() {
    $fish = explode(',',$this->_readInput()[0]);
    echo implode(',', $fish) . "\n";
    for ($d = 1; $d <= 80; $d++) {
      $spawned = [];
      for ($i = 0; $i < count($fish); $i++) {
        $fish[$i]--;
        if ($fish[$i] == -1) {
          $fish[$i] = 6;
          $spawned[] = 8;
        }
      }
      $fish = array_merge($fish, $spawned);
      //echo implode(',', $fish) . "\n";
    }
    echo count($fish) . "\n";
  }
}
