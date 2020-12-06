<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\Commands\Advent\AdventBase;

class Day3Part2 extends AdventBase {

  protected $signature = "year2020:day3part2";
  protected $description = "Advent Of Code 2020 Day 3 Part 2";

  public function handle() {
    $map = $this->_readInput();

    $accumulator = 1;
    $accumulator *= $this->countTrees(1, 1, $map);
    echo "product: " . $accumulator . "\n";
    $accumulator *= $this->countTrees(3, 1, $map);
    echo "product: " . $accumulator . "\n";
    $accumulator *= $this->countTrees(5, 1, $map);
    echo "product: " . $accumulator . "\n";
    $accumulator *= $this->countTrees(7, 1, $map);
    echo "product: " . $accumulator . "\n";
    $accumulator *= $this->countTrees(1, 2, $map);
    echo "product: " . $accumulator . "\n";
  }

  protected function countTrees($right_increment, $down_increment, $map) {
    $hill_height = count($map);
    $map_width = strlen($map[0]);
    $y = 0;
    $x = 0;
    $trees = 0;
    while ($y < $hill_height) {
      // echo "--------------------\n";
      // echo "y: " . $y . "\n";
      // echo "x: " . $x . "\n";
      // echo "map_width: " . $map_width . "\n";
      // echo "x % map_width: " . $x % $map_width . "\n";
      // echo "map row: " . $map[$y] . "\n";
      // echo "map spot: " . $map[$y][$x % $map_width] . "\n";
      if ($map[$y][$x % $map_width] == "#") {
        // echo "TREE!\n";
        $trees++;
      }
      $x += $right_increment;
      $y += $down_increment;
    }
    return $trees;
  }
}
