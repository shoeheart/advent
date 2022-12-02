<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2021;

use App\Console\AdventBase;

class Day5Part2 extends AdventBase {

  protected $signature = "year2021:day5part2";
  protected $description = "Advent Of Code 2021 Day 5 Part 2";

  public function handle() {
    $rows = $this->_readInput();
    $lines = [];
    $highestX = -1;
    $highestY = -1;
    for ($i = 0; $i < count($rows); $i++) {
      $endpoints = explode(' -> ', $rows[$i]);
      list($x1, $y1) = explode(',', $endpoints[0]);
      list($x2, $y2) = explode(',', $endpoints[1]);
      $highestX = max($x1, $x2, $highestX);
      $highestY = max($y1, $y2, $highestY);
      $xIncr = ($x1 < $x2) ? 1 : (($x1 > $x2) ? -1 : 0);
      $yIncr = ($y1 < $y2) ? 1 : (($y1 > $y2) ? -1 : 0);
      $points = [];
      for( $x = $x1, $y = $y1; ($x - $xIncr != $x2) || ($y - $yIncr != $y2); $x += $xIncr, $y += $yIncr) {
        $points[] = [$x, $y];
      }
      $lines[] = array(
        'horizontal' => ($y1 == $y2) ? 1 : 0,
        'vertical' => ($x1 == $x2) ? 1 : 0,
        'x1' => $x1,
        'y1' => $y1,
        'x2' => $x2,
        'y2' => $y2,
        'points' => $points,
      );
    }
    //echo (print_r($lines, true));
    echo "gridWidth: $highestX\n";
    echo "gridHeight: $highestY\n";

    $grid = [];
    foreach($lines as $line) {
      foreach($line['points'] as $point) {
        if (!isset($grid[$point[1]])) {
          $grid[$point[1]] = [];
        }
        if (!isset($grid[$point[1]][$point[0]])) {
          $grid[$point[1]][$point[0]] = 0;
        }
        $grid[$point[1]][$point[0]] += 1;
      }
    }

    $dangerCount = 0;
    for( $y = 0; $y <= $highestY; $y++) {
      for( $x = 0; $x <= $highestX; $x++) {
        if (isset($grid[$y][$x]) && $grid[$y][$x] > 1) {
          $dangerCount++;
        }
        //echo isset($grid[$y][$x]) ? $grid[$y][$x] : '.';
      }
      //echo "\n";
    }
    echo "danger: $dangerCount\n";

    // $a = [];
    // $a[0] = [];
    // $a[9] = [];
    // $a[0][0] = 1;
    // $a[9][9] = 1;
    // echo "00:" . $a[0][0] . "\n";
    // echo "99:" . $a[9][9] . "\n";
    // echo "55:" . $a[5][5] . "\n";
    // echo "1515:" . $a[15][15] . "\n";
    // echo (print_r($a, true));
    // echo count($a) . "\n";
    // echo count($a[0]) . "\n";
    // echo count($a[9]) . "\n";

  }
}
