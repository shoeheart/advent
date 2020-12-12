<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\Commands\Advent\AdventBase;

class Day12Part2 extends AdventBase {

  protected $signature = "year2020:day12part2";
  protected $description = "Advent Of Code 2020 Day 12 Part 2";
  protected $_lines = [];

  public function handle() {
    $raw = $this->_readInput();
    foreach($raw as $r) {
      $this->_lines[] = array(
        'instruction' => substr($r, 0, 1),
        'distance' => intval(substr($r,1))
      );
    }

    $wayRelativeX = 10;
    $wayRelativeY = -1;
    $x = 0;
    $y = 0;
    foreach($this->_lines as $line) {
      $to = $line['instruction'];
      $howFar = $line['distance'];
      switch($to) {
        case 'N':
          $wayRelativeY -= $howFar;
          break;
        case 'S':
          $wayRelativeY += $howFar;
          break;
        case 'E':
          $wayRelativeX += $howFar;
          break;
        case 'W':
          $wayRelativeX -= $howFar;
          break;
        case 'L':
          for($i = 0; $i < (($howFar % 360) / 90); $i++) {
            $originalWayRelativeX = $wayRelativeX;
            $originalWayRelativeY = $wayRelativeY;

            $wayRelativeX = $originalWayRelativeY;
            $wayRelativeY = (0 - $originalWayRelativeX);
            // echo "L new waypoint: $wayRelativeX,$wayRelativeY\n";
          }
          break;
        case 'R':
          for($i = 0; $i < (($howFar % 360) / 90); $i++) {
            $originalWayRelativeX = $wayRelativeX;
            $originalWayRelativeY = $wayRelativeY;

            $wayRelativeX = (0 - $originalWayRelativeY);
            $wayRelativeY = $originalWayRelativeX;
            // echo "R new waypoint: $wayRelativeX,$wayRelativeY\n";
          }
          break;
        case 'F':
          for($i = 0; $i < $howFar; $i++) {
            $x += $wayRelativeX;
            $y += $wayRelativeY;
          }
          break;
        default:
          // echo "bad instruction $to";
          exit -1;
      }
      // echo "got here: $x, $y, $wayRelativeX, $wayRelativeY\n";
    }
    // echo "done\n";
    // echo "$x,$y\n";
    echo "manhattan: " . (abs($x) + abs($y)) . "\n";
  }
}