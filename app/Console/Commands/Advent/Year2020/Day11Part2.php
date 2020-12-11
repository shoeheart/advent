<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\Commands\Advent\AdventBase;

class Day11Part2 extends AdventBase {

  protected $signature = "year2020:day11part2";
  protected $description = "Advent Of Code 2020 Day 11 Part 2";
  protected $_originalMap = [];

  protected function _isOccupied($map, $x, $y, $xinc, $yinc) {
    // echo "  $x, $y, $xinc, $yinc\n";
    if ($x < 0) return false;
    if ($y < 0) return false;
    $height = count($map);
    $width = strlen($map[0]);
    if ($x >= $width) return false;
    if ($y >= $height) return false;

    // if spot is floor, look one past
    if ($map[$y][$x] == '.') {
      // echo "    recurse:\n";
      return $this->_isOccupied($map, $x + $xinc, $y + $yinc, $xinc, $yinc);
    }
    // otherwise report whether nearest in this direction
    // is occupied (true) or seat (false)
    // echo "    end case based on $x, $y: " . $map[$x][$y] . "\n";
    return ($map[$y][$x] == '#');
  }

  protected function _nextOccupancy($currentMap, &$nextMap, $x, $y) {
    // echo "$y, $x\n";
    $currentSpot = $currentMap[$y][$x];
    if ($currentSpot == '.') return false;
    $neighborsOccupied =
      $this->_isOccupied($currentMap, $x - 1, $y - 1, -1,  -1) +
      $this->_isOccupied($currentMap, $x + 0, $y - 1,  0,  -1) +
      $this->_isOccupied($currentMap, $x + 1, $y - 1,  1,  -1) +

      $this->_isOccupied($currentMap, $x - 1, $y + 0, -1,  0) +
      $this->_isOccupied($currentMap, $x + 1, $y + 0,  1,  0) +

      $this->_isOccupied($currentMap, $x - 1, $y + 1, -1,  1) +
      $this->_isOccupied($currentMap, $x + 0, $y + 1,  0,  1) +
      $this->_isOccupied($currentMap, $x + 1, $y + 1,  1,  1);
    // echo "neighborsOccupied: $neighborsOccupied\n";

    if ($currentSpot == 'L') {
      if ($neighborsOccupied == 0) {
        $nextMap[$y][$x] = '#';
        return true;
      }
    }

    if ($currentSpot == '#') {
      if ($neighborsOccupied >= 5) {
        $nextMap[$y][$x] = 'L';
        return true;
      }
    }

    return false;
  }

  protected function _countOccupied($map) {
    $sum = 0;
    for ($y = 0; $y < count($map); $y++) {
      for ($x = 0; $x < strlen($map[$y]); $x++) {
        if ($map[$y][$x] == '#') {
          $sum++;
        }
      }
    }
    return $sum;
  }

  public function handle() {
    $this->_originalMap = $this->_readInput();

    $currentMap = $this->_originalMap;
    $somethingChanged = true;
    $iterations = 0;
    while($somethingChanged) {
      echo "iteration: $iterations\n";
      // print_r($currentMap);
      echo "\n";
      $somethingChanged = false;
      $nextMap = $currentMap;
      for ($y = 0; $y < count($currentMap); $y++) {
        for ($x = 0; $x < strlen($currentMap[$y]); $x++) {
          $somethingChanged =
            $this->_nextOccupancy($currentMap, $nextMap, $x, $y) ||
            $somethingChanged;
        }
      }
      $iterations++;
      $currentMap = $nextMap;
    }

    echo "iterations: $iterations\n";
    echo "occupied: " . $this->_countOccupied($currentMap) . "\n";
  }
}
