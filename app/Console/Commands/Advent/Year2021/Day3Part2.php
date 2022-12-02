<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2021;

use App\Console\AdventBase;

class Day3Part2 extends AdventBase {

  protected $signature = "year2021:day3part2";
  protected $description = "Advent Of Code 2021 Day 3 Part 2";

  public function sortLinesByBit($lines, $position) {
    $sortedLines = array( 0 => [], 1 => [] );
    for ($i = 0; $i < count($lines); $i++) {
      $bit = substr($lines[$i], $position, 1);
      array_push($sortedLines[$bit], $lines[$i]);
    }
    return $sortedLines;
  }

  public function handle() {
    $lines = $this->_readInput();

    // find last most popular line, favoring 1
    $remainder = $lines;
    for ($i = 0; $i < strlen($lines[0]); $i++) {
      $sorted = $this->sortLinesByBit($remainder, $i);
      if (count($sorted[0]) == 0) {
        $remainder = $sorted[1];
      } else if (count($sorted[1]) == 0) {
        $remainder = $sorted[0];
      } else if (count($sorted[1]) >= count($sorted[0])) {
        $remainder = $sorted[1];
      } else {
        $remainder = $sorted[0];
      }
    }
    $oxygen = $remainder[0];

    // find last least popular line, favoring 0
    $remainder = $lines;
    for ($i = 0; $i < strlen($lines[0]); $i++) {
      $sorted = $this->sortLinesByBit($remainder, $i);
      if (count($sorted[0]) == 0) {
        $remainder = $sorted[1];
      } else if (count($sorted[1]) == 0) {
        $remainder = $sorted[0];
      } else if (count($sorted[0]) <= count($sorted[1])) {
        $remainder = $sorted[0];
      } else {
        $remainder = $sorted[1];
      }
    }
    $co2 = $remainder[0];

    echo "$oxygen, $co2\n";
    echo bindec($oxygen) . "\n";
    echo bindec($co2) . "\n";
    echo bindec($oxygen) * bindec($co2) . "\n";
  }
}
