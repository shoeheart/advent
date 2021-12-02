<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2021;

use App\Console\Commands\Advent\AdventBase;

class Day2Part2 extends AdventBase {

  protected $signature = "year2021:day2part2";
  protected $description = "Advent Of Code 2021 Day 2 Part 2";

  public function handle() {
    $lines = $this->_readInput();
    $x = $y = $aim = 0;
    for ($i = 0; $i < count($lines); $i++) {
      $parts = explode(' ', $lines[$i]);
      if (strpos($parts[0], 'forward') !== false) {
        $x += (int)$parts[1];
        $y += $aim * (int)$parts[1];
      } else if (strpos($parts[0], 'down') !== false) {
        $aim += (int)$parts[1];
      } else if (strpos($parts[0], 'up') !== false) {
        $aim -= (int)$parts[1];
      } else {
        echo "BOOM\n";
        echo print_r($parts,true);
        echo "BOOM\n";
        exit -1;
      }
    }
    echo "x,y,x*y = $x, $y, " . $x * $y . "\n";
  }
}
