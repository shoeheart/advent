<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day15Part2 extends AdventBase {

  protected $signature = "year2020:day15part2";
  protected $description = "Advent Of Code 2020 Day 15 Part 2";
  protected $_latest = [];
  protected $_prior = [];

  protected function _calculateNext($lastNumber, $turn) {
    if (isset($this->_prior[$lastNumber])) {
      return
        $this->_latest[$lastNumber] -
        $this->_prior[$lastNumber];
    } else {
      return 0;
    }
  }

  protected function _speak($number, $turn) {
    echo "Turn $turn: $number\n";
    if (isset($this->_latest[$number])) {
      $this->_prior[$number] = $this->_latest[$number];
    }
    $this->_latest[$number] = $turn;
  }

  public function handle() {
    $lines = $this->_readInput();
    $startingNumbers = explode(',', $lines[0]);
    $turn = 1;
    foreach ($startingNumbers as $number) {
      $this->_speak($number, $turn);
      $turn++;
    }
    print_r($this->_latest);
    print_r($this->_prior);
    echo "\n";

    $this->_speak(0, $turn);
    $turn++;
    print_r($this->_latest);
    print_r($this->_prior);
    echo "\n";

    $lastNumberSpoken = 0;
    for (; $turn < 30000001; $turn++) {
      $lastNumberSpoken =
        $this->_calculateNext($lastNumberSpoken, $turn);
      $this->_speak($lastNumberSpoken, $turn);
    }
  }
}
