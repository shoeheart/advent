<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2019;

use App\Console\Commands\Advent\AdventBase;

class Day1Part2 extends AdventBase {

  protected $signature = "year2019:day1part2";
  protected $description = "Advent Of Code 2019 Day 1 Part 2";

  protected function fuelForMass($mass) {
    $required = intdiv($mass, 3) - 2;
    if ($required <= 0) {
      return 0;
    } else {
      return $required + $this->fuelForMass($required);
    }
  }

  public function handle() {
    $lines = $this->_readInput();
    $sum = 0;
    foreach($lines as $line) {
      $sum += $this->fuelForMass(intval($line));
    }
    echo $sum . "\n";
  }
}
