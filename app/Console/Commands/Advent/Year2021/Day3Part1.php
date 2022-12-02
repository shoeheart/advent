<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2021;

use App\Console\AdventBase;

class Day3Part1 extends AdventBase {

  protected $signature = "year2021:day3part1";
  protected $description = "Advent Of Code 2021 Day 3 Part 1";

  public function handle() {
    $lines = $this->_readInput();
    $positionCount = array();
    for ($i = 0; $i < count($lines); $i++) {
      $bits = str_split($lines[$i]);
      foreach ($bits as $index => $value) {
        if (empty($positionCount[$index])) {
          $positionCount[$index] = array( 0 => 0, 1 => 0);
        }
        $positionCount[$index][$value]++;
      }
    }
    $gammaMostPopular = 0;
    $epsilonLeastPopular = 0;

    foreach ($positionCount as $bitCounts) {
      if ($bitCounts[0] == $bitCounts[1]) {
        echo "nobody wins " . print_r($bitCounts, true);
        exit -1;
      }
      $gammaMostPopular *= 2;
      $epsilonLeastPopular *= 2;
      if ($bitCounts[0] > $bitCounts[1]) {
        // zero is more popular so gamma += 0, episolon += 1 at this spot
        $epsilonLeastPopular += 1;
      } else {
        $gammaMostPopular += 1;
      }
    }
    echo "$gammaMostPopular,$epsilonLeastPopular\n";
    echo $gammaMostPopular * $epsilonLeastPopular . "\n";
  }
}
