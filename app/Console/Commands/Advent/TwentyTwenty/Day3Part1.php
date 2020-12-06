<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\TwentyTwenty;

use App\Console\Commands\Advent\AdventBase;

class Day3Part1 extends AdventBase {

  protected $signature = "day3part1:perform";
  protected $description = "Advent Of Code 2020 Day 3 Part 1";

  public function handle() {
    $map = $this->_readInput();

    $right_increment = 3;
    $down_increment = 1;
    $hill_height = count($map);
    $map_width = strlen($map[0]);

    $y = 0;
    $x = 0;
    $trees = 0;
    while ($y < $hill_height) {
      echo "--------------------\n";
      echo "y: " . $y . "\n";
      echo "x: " . $x . "\n";
      echo "map_width: " . $map_width . "\n";
      echo "x % map_width: " . $x % $map_width . "\n";
      echo "map row: " . $map[$y] . "\n";
      echo "map spot: " . $map[$y][$x % $map_width] . "\n";
      if ($map[$y][$x % $map_width] == "#") {
        echo "TREE!\n";
        $trees++;
      }
      $x += $right_increment;
      $y += $down_increment;
    }
    echo "trees: " . $trees . "\n";
  }
}
