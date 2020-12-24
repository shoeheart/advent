<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\Commands\Advent\AdventBase;

class Day24Part2 extends AdventBase {

  protected $signature = "year2020:day24part2";
  protected $description = "Advent Of Code 2020 Day 24 Part 2";

  //           /\
  //     nw   /  \  ne
  //         /    \
  //        |      |
  //      w |      | e
  //        |      |
  //         \    /
  //     sw   \  /  se
  //           \/

  protected function _calculateNeighbors($key) {
    //echo "exploding $key\n";
    list($x,$y) = explode('|', $key);
    $x = floatval($x);
    $y = floatval($y);

    $neighbors[] = ($x - 0.5) . "|" . ($y - 0.5);
    $neighbors[] = ($x - 0.5) . "|" . ($y + 0.5);
    $neighbors[] = ($x + 0.5) . "|" . ($y - 0.5);
    $neighbors[] = ($x + 0.5) . "|" . ($y + 0.5);
    $neighbors[] = ($x - 1.0) . "|" .  $y       ;
    $neighbors[] = ($x + 1.0) . "|" .  $y       ;

    return $neighbors;
  }

  protected function _countFlippedNeighbors($key, $flipped) {
    //echo "_countFlippedNeighbors: $key\n";
    $neighbors = $this->_calculateNeighbors($key);
    $count = 0;
    foreach ($neighbors as $key) {
      //echo "counting neighbor $key\n";
      if (isset($flipped[$key])) {
        $count++;
      }
    }
    return $count;
  }

  public function handle() {
    $lines = $this->_readInput();
    foreach($lines as $line) {
      $flipSets[] = explode(',', $line);
    }
    //print_r($flipSets);

    $flipped = array();
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
      //echo "$x, $y: $key\n";
      if (isset($flipped[$key])) {
        unset($flipped[$key]);
      } else {
        $flipped[$key] = 'black';
      }
    }
    //echo "flipped tiles\n";
    //print_r($flipped);
    //echo "black tiles: " . count($flipped) . "\n";

    $sum = 0;
    for ($i = 1; $i <= 100; $i++) {

      // only need to check black tiles, and tiles adjacent to black tiles
      $tilesToCheck = array_keys($flipped);
      foreach($flipped as $key => $_) {
        // echo "tile $key neighbors:\n";
        // print_r($this->_calculateNeighbors($tile));
        $tilesToCheck = array_merge($tilesToCheck, $this->_calculateNeighbors($key));
      }

      // echo "tilesToCheck\n";
      // print_r($tilesToCheck);
      // sort($tilesToCheck);
      // echo "sorted tilesToCheck\n";
      // print_r($tilesToCheck);
      // $tilesToCheck = array_unique($tilesToCheck);
      // echo "unique tilesToCheck\n";
      // print_r($tilesToCheck);


      $previousFlipped = $flipped;
      $flipped = array();
      foreach($tilesToCheck as $key) {
        //echo "testing $key\n";
        $flippedNeighbors = $this->_countFlippedNeighbors($key, $previousFlipped);
        //echo "$key neighbors $flippedNeighbors\n";
        if (isset($previousFlipped[$key])) {
          // was flipped to black already
          if (! ($flippedNeighbors == 0 || $flippedNeighbors > 2)) {
            // don't have 0 or >2 flipped neighbors so stay flipped
            // in next iteration
            $flipped[$key] = 'black';
          }
        } else {
          // was unflipped and hence white
          if ($flippedNeighbors == 2) {
            $flipped[$key] = 'black';
          }
        }
      }
      //print_r($flipped);
      echo "Day $i flipped tiles: " . count($flipped) . "\n";
    }
  }
}
