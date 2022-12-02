<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day13Part1 extends AdventBase {

  protected $signature = "year2020:day13part1";
  protected $description = "Advent Of Code 2020 Day 13 Part 1";
  protected $_lines = [];

  public function handle() {
    $raw = $this->_readInput();
    $earliestTimestamp = intval($raw[0]);
    $busses = [];
    foreach(explode(',', $raw[1]) as $bus) {
      if ($bus =='x') continue;
        $bus = intval($bus);
        // $busses[$bus] = $earliestTimestamp - intdiv($earliestTimestamp, $bus);
        // $busses[$bus] = $earliestTimestamp % $bus;
        $busses[$bus] = $bus - ($earliestTimestamp % $bus);
    }
    echo $earliestTimestamp;
    echo "\n";
    print_r($busses);
    echo "\n";
    $soonestBus = -1;
    foreach($busses as $bus => $wait) {
      if ($soonestBus == -1) {
        $soonestBus = $bus;
      } else {
        if ($wait < $busses[$soonestBus]) {
          $soonestBus = $bus;
        }
      }
    }
    echo "answer: " . $soonestBus * $busses[$soonestBus] . "\n";
  }
}
