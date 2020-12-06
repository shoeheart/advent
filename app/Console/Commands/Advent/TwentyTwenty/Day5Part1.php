<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\TwentyTwenty;

use App\Console\Commands\Advent\AdventBase;

class Day5Part1 extends AdventBase {

  protected $signature = "day5part1:perform";
  protected $description = "Advent Of Code 2020 Day 5 Part 1";

  public function handle() {
    $boardingPasses = $this->_readInput();

    $highestSeatID = -1;
    foreach ($boardingPasses as $boardingPass) {
      // row:     first 7 characters, B == 1, F == 0
      // column:  last 3 characters, R == 1, L == 0
      // seat ID: row * 8 + seat column
      preg_match('/^([F|B]{7})([R|L]{3})$/', $boardingPass, $matches);

      // print_r($matches);
      $row = $matches[1];
      $row = str_replace(['F', 'B'], ['0', '1'], $row);
      $col = $matches[2];
      $col = str_replace(['L', 'R'], ['0', '1'], $col);
      // echo $row . ": " . bindec($row) . "\n";
      // echo $col . ": " . bindec($col) . "\n";
      $seatID = bindec($row) * 8 + bindec($col);
      if ($seatID > $highestSeatID) {
        $highestSeatID = $seatID;
      }
    }

    echo "highestSeatID: " . $highestSeatID . "\n";
  }
}
