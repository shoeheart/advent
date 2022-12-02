<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day9Part1 extends AdventBase {

  protected $signature = "year2020:day9part1";
  protected $description = "Advent Of Code 2020 Day 9 Part 1";
  protected $_lines = [];


  protected function _sumIsFound($targetIndex, $preambleLength) {
    $preambleStart = $targetIndex - $preambleLength;
    for ($i = $preambleStart; $i < ($targetIndex - 1); $i++) {
      for ($j = $preambleStart + 1; $j < $targetIndex; $j++) {
        if (
          ($this->_lines[$i] + $this->_lines[$j]) ==
          $this->_lines[$targetIndex]
        ) {
          return true;
        }
      }
    }
    return false;
  }

  public function handle() {
    $this->_lines = $this->_readInput();

    $preambleLength = 25;
    for($i = $preambleLength; $i < count($this->_lines); $i++) {
      if ($this->_sumIsFound($i, $preambleLength)) {
        continue;
      } else {
        echo "No preamble sum matches index $i value " . $this->_lines[$i] . "\n";
        exit( 0 );
      }
    }
    echo "umm...everything is possible sum...\n";
  }
}
