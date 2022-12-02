<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day10Part2 extends AdventBase {

  protected $signature = "year2020:day10part2";
  protected $description = "Advent Of Code 2020 Day 10 Part 2";
  protected $_lines = [];
  protected $_savedCounts = [];


  // for each index in sorted array,
  //   if index == last spot, return 1 (chain completed)
  //   find subsequent indices whose value is +1, +2, or +3.
  //   if list is empty, return 0
  //   $sum = 0;
  //   foreach of those,
  //     $sum += completeChain($subsequentIndex)

  //   return $sum

  protected function _completeChain($startingIndex, $iteration, $depth) {
    echo "iteration: $iteration, depth: $depth\n";
    echo "completing $startingIndex: " . $this->_lines[$startingIndex] . "\n";
    if ($startingIndex == count($this->_lines) - 1) {
      echo "hit end\n";
      return 1;
    }

    // powerset explosion that requires a cray
    // if we don't save previously calculated results
    if (isset($this->_savedCounts[$startingIndex])) {
      echo "shunting $startingIndex\n";
      return $this->_savedCounts[$startingIndex];
    }

    $currentJoltage = $this->_lines[$startingIndex];
    $sum = 0;
    $bother = true;
    for ($i = $startingIndex + 1; $i < count($this->_lines) && $bother; $i++) {
      $diff = ($this->_lines[$i] - $currentJoltage);
      if ($diff > 0 && $diff <= 3 ) {
        echo "processing $i: " . $this->_lines[$i] . "\n";
        $sum += $this->_completeChain($i, $iteration + 1, $depth + 1);
      } else {
        echo "skipping $i: " . $this->_lines[$i] . "\n";
        $bother = false;
      }
    }
    echo "returning $sum\n";
    $this->_savedCounts[$startingIndex] = $sum;
    return $sum;
  }

  public function handle() {
    $input = $this->_readInput();
    sort($input);
    $this->_lines = array_merge(
      array(0),
      $input,
      array(end($input) + 3)
    );
    print_r($this->_lines);

    echo "chains: " . $this->_completeChain(0, 1, 0);
  }
}
