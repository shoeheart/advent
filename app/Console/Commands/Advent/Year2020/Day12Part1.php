<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\Commands\Advent\AdventBase;

class Day12Part1 extends AdventBase {

  protected $signature = "year2020:day12part1";
  protected $description = "Advent Of Code 2020 Day 12 Part 1";
  protected $_lines = [];

  public function handle() {
    $raw = $this->_readInput();
    foreach($raw as $r) {
      $this->_lines[] = array(
        'instruction' => substr($r, 0, 1),
        'distance' => intval(substr($r,1))
      );
    }

    $x = 0;
    $y = 0;
    $direction = 90;
    foreach($this->_lines as $line) {
      $to = $line['instruction'];
      $howFar = $line['distance'];
      // echo "loop: $x,$y,$to,$howFar,$direction\n";
      switch($to) {
        case 'N':
          $y -= $howFar;
          break;
        case 'S':
          $y += $howFar;
          break;
        case 'E':
          $x += $howFar;
          break;
        case 'W':
          $x -= $howFar;
          break;
        case 'L':
          $direction = ($direction - $howFar) % 360;
          // echo "L: $direction\n";
          while($direction < 0) {
            $direction += 360;
            // echo "Ladjust: $direction\n";
          }
          break;
        case 'R':
          $direction = ($direction + $howFar) % 360;
          break;
        case 'F':
          // echo "F: $direction,$howFar\n";
          switch($direction) {
            case 0:
              $y -= $howFar;
              break;
            case 90:
              $x += $howFar;
              break;
            case 180:
              // echo "180: $y,$howFar\n";
              $y += $howFar;
              break;
            case 270:
              $x -= $howFar;
              break;
            default:
              // echo "bad direction $direction\n";
              exit -1;
          }
          break;
        default:
          // echo "bad dir $to";
          exit -1;
      }
      // echo "got here: $x, $y\n";
    }
    // echo "done\n";
    // echo "$x,$y\n";
    echo "manhattan: " . (abs($x) + abs($y)) . "\n";
  }
}