<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day17Part1 extends AdventBase {

  protected $signature = "year2020:day17part1";
  protected $description = "Advent Of Code 2020 Day 17 Part 1";

  protected function _makeKey($x, $y, $z) {
    return ($x . "|" . $y . "|" . $z);
  }

  protected function _splitKey($key) {
    return explode('|', $key);
  }

  protected function _getDimensions($positives) {
    list($xMin, $xMax, $yMin, $yMax, $zMin, $zMax) =
      array(
        999,
        -999,
        999,
        -999,
        999,
        -999
      );
    foreach($positives as $key => $_) {
      //echo "key: $key\n";
      //print_r(explode('|', $key));
      //echo "\n";
      list($x, $y, $z) = $this->_splitKey($key);
      if ($x < $xMin) $xMin = $x;
      if ($x > $xMax) $xMax = $x;
      if ($y < $yMin) $yMin = $y;
      if ($y > $yMax) $yMax = $y;
      if ($z < $zMin) $zMin = $z;
      if ($z > $zMax) $zMax = $z;
    }
    return array($xMin, $xMax, $yMin, $yMax, $zMin, $zMax);
  }

  protected function _getDimensionsExpanded($positives) {
    list($xMin, $xMax, $yMin, $yMax, $zMin, $zMax) =
      $this->_getDimensions($positives);
    return
      array($xMin - 1, $xMax + 1, $yMin - 1, $yMax + 1, $zMin - 1, $zMax + 1);
  }

  protected function _print($positives) {
    list($xMin, $xMax, $yMin, $yMax, $zMin, $zMax) =
      $this->_getDimensions($positives);

    //echo "dimensions:\n";
    //print_r(array($xMin, $xMax, $yMin, $yMax, $zMin, $zMax));
    //echo "\n";
    for($z = $zMin; $z <= $zMax; $z++) {
      echo "z = $z:\n";
      for($y = $yMin; $y <= $yMax; $y++) {
        for($x = $xMin; $x <= $xMax; $x++) {
          //if (isset($positives[$this->_makeKey($x, $y, $z)])) {
          if ($this->_isPositive($positives, $x, $y, $z)) {
            echo "#";
          } else {
            echo ".";
          }
        }
        echo "\n";
      }
    }
  }

  protected function _isPositive($positives, $x, $y, $z) {
    return isset($positives[$this->_makeKey($x, $y, $z)]);
  }

  protected function _countPositiveNeighbors($positives, $x, $y, $z) {

    //echo "calculating positive neighbors of $x, $y, $z\n";
    list($xMin, $xMax, $yMin, $yMax, $zMin, $zMax) =
      $this->_getDimensionsExpanded(array($this->_makeKey($x, $y, $z) => 1));
    //echo "exploring dimensions:\n";
    //print_r(array($xMin, $xMax, $yMin, $yMax, $zMin, $zMax));
    //echo "\n";
    $sum = 0;
    for($x1 = $xMin; $x1 <= $xMax; $x1++) {
      for($y1 = $yMin; $y1 <= $yMax; $y1++) {
        for($z1 = $zMin; $z1 <= $zMax; $z1++) {
          if ($x1 == $x && $y1 == $y && $z1 == $z) {
            continue;
          }
          if ($this->_isPositive($positives, $x1, $y1, $z1)) {
            // echo " adding $x1, $y1, $z1 as positive neighbor\n";
            $sum += 1;
          }
        }
      }
    }
    //echo "  returning $sum\n";
    return $sum;
  }

  public function handle() {
    $lines = $this->_readInput();

    $positives = [];
    $z = 0;
    $y = 0;
    foreach($lines as $line) {
      $x = 0;
      foreach(str_split($line) as $cell) {
        if ($cell == '#') {
          $positives[$this->_makeKey($x, $y, $z)] = 1;
        }
        $x++;
      }
      $y++;
    }

    // print_r($positives);
    $this->_print($positives);
    echo "\n";

    //$this->_countPositiveNeighbors($positives, 2, 2, 0);
    //exit;


    // do cycles
    for ($i = 0; $i < 6; $i++) {
      $oldPositives = $positives;
      $positives = [];

      list($xMin, $xMax, $yMin, $yMax, $zMin, $zMax) =
        $this->_getDimensionsExpanded($oldPositives);

      // build new space
      for($x = $xMin; $x <= $xMax; $x++) {
        for($y = $yMin; $y <= $yMax; $y++) {
          for($z = $zMin; $z <= $zMax; $z++) {
            $positiveNeighbors =
              $this->_countPositiveNeighbors($oldPositives, $x, $y, $z);
            // echo "  positive neighbors of $x, $y, $z: $positiveNeighbors\n";
            if ($this->_isPositive($oldPositives, $x, $y, $z)) {
              if ($positiveNeighbors == 2 || $positiveNeighbors == 3) {
                $positives[$this->_makeKey($x, $y, $z)] = 1;
              }
            } else {
              if ($positiveNeighbors == 3) {
                $positives[$this->_makeKey($x, $y, $z)] = 1;
              }
            }
          }
        }
      }
    }

    $this->_print($positives);
    echo "\n";
    echo "positive count: " . count($positives) . "\n";
  }
}
