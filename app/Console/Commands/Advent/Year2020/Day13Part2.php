<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day13Part2 extends AdventBase {

  protected $signature = "year2020:day13part2";
  protected $description = "Advent Of Code 2020 Day 13 Part 2";
  protected $_busses = [];

  protected function _isValid($time, $busIndex, $busID) {
    //echo "testing: $time, $busIndex, $busID\n";
    return (
      ($busID == 'x') ||
      // seems to work???
      ((($time + $busIndex) % $busID) == 0)
      // bad???
      // (($busID - ($time % $busID)) == ($busIndex % $busID))
    );
  }

  public function handle() {
    $raw = $this->_readInput();
    $i = 0;
    foreach(explode(',', $raw[1]) as $busID) {
      if ($busID != 'x') {
        $this->_busses[$busID] = $i;
      }
      $i++;
    }
    krsort($this->_busses);
    print_r($this->_busses);
    echo "\n";
    $highestBusID = array_key_first($this->_busses);
    // sample data
    //$start = intdiv(1060000, $highestBusID) * $highestBusID - $this->_busses[$highestBusID];
    // tiny data
    // $start = intdiv(1, $highestBusID) * $highestBusID - $this->_busses[$highestBusID];
    // real data
    // $start = intdiv(100000000000000, $highestBusID) * $highestBusID - $this->_busses[$highestBusID];
    // $start = intdiv(471793476184394, $highestBusID) * $highestBusID - $this->_busses[$highestBusID];
    $start = intdiv(1, $highestBusID) * $highestBusID - $this->_busses[$highestBusID];
    echo "starting at time $start, which is " . $this->_busses[$highestBusID] . " less than a multiple of $highestBusID\n";
    $incrementBy = $highestBusID;
    $highestFound = 0;
    $iterations = 0;
    for($time = $start;; $time += $incrementBy) {
      $iterations++;
      //echo "at time $time\n";
      $allValid = true;
      $i = 0;
      foreach($this->_busses as $busID => $busIndex) {
        // don't recalculate first one each time
        // since we know it's a multiple
        if ($i > 0) {
          if($this->_isValid($time, $busIndex, $busID)) {
            // echo "found index $i for time $time, busID $busID, busIndex $busIndex\n";
            if ($i > $highestFound) {
              $incrementBy = $incrementBy * $busID;
              $highestFound = $i;
              echo "setting incrementBy to $incrementBy\n";
            }
          } else {
            break;
          }
        }
        $i++;
      }
      if ($i == count($this->_busses)) {
        echo "answer: " . number_format($time) . "\n";
        echo "in $iterations iterations\n";
        exit;
      }
    }
  }
}
