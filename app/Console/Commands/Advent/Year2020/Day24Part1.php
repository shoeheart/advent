<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day24Part1 extends AdventBase {

  protected $signature = "year2020:day24part1";
  protected $description = "Advent Of Code 2020 Day 24 Part 1";

  //           /\
  //     nw   /  \  ne
  //         /    \
  //        |      |
  //      w |      | e
  //        |      |
  //         \    /
  //     sw   \  /  se
  //           \/


  public function handle() {
    $lines = $this->_readInput();
    foreach($lines as $line) {
      $flipSets[] = explode(',', $line);
    }
    print_r($flipSets);

    $tiles = array();
    foreach($flipSets as $flipSet) {
      $x = 0.0;
      $y = 0.0;
      foreach($flipSet as $flip) {
        switch ($flip) {
          case 'nw':
            $x -= 0.5;
            $y -= 0.5;
            break;
          case 'sw':
            $x -= 0.5;
            $y += 0.5;
            break;
          case 'ne':
            $x += 0.5;
            $y -= 0.5;
            break;
          case 'se':
            $x += 0.5;
            $y += 0.5;
            break;
          case 'w':
            $x -= 1.0;
            break;
          case 'e':
            $x += 1.0;
            break;
        }
      }
      $key = "$x|$y";
      echo "$x, $y: $key\n";
      if (isset($tiles[$key])) {
        unset($tiles[$key]);
      } else {
        $tiles[$key] = 'black';
      }
    }
    print_r($tiles);
    echo "black tiles: " . count($tiles) . "\n";
  }
}
