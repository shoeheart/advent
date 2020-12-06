<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\Commands\Advent\AdventBase;

class Day5Part2 extends AdventBase {

  protected $signature = "year2020:day5part2";
  protected $description = "Advent Of Code 2020 Day 5 Part 2";

  public function handle() {
    $boardingPasses = $this->_readInput();

    $occupiedSeats = [];
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
      $occupiedSeats[] = $seatID;
    }
    print_r($occupiedSeats);
    sort($occupiedSeats);
    print_r($occupiedSeats);
    foreach($occupiedSeats as $index => $seatID) {
      if (
        // can't be first seat
        $index > 0
        &&
        // can't be last seat
        $index < count($occupiedSeats) - 1
        &&
        // seatID before current seat must 2 higher
        // to allow room for one unoccupied seat between
        $occupiedSeats[$index - 1] == ($seatID - 2)
      ) {
        echo "unoccupied seat: " . ($seatID - 1) . "\n";
      }
    }
  }
}
