<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2021;

use App\Console\AdventBase;

class Day2Part1 extends AdventBase {

  protected $signature = "year2021:day2part1";
  protected $description = "Advent Of Code 2021 Day 2 Part 1";

  public function handle() {
    $lines = $this->_readInput();
    $x = $y = 0;
    for ($i = 0; $i < count($lines); $i++) {
      $parts = explode(' ', $lines[$i]);
      if (strpos($parts[0], 'forward') !== false) {
        $x += (int)$parts[1];
      } else if (strpos($parts[0], 'down') !== false) {
        $y += (int)$parts[1];
      } else if (strpos($parts[0], 'up') !== false) {
        $y -= (int)$parts[1];
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
