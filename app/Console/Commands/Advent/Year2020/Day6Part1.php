<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day6Part1 extends AdventBase {

  protected $signature = "year2020:day6part1";
  protected $description = "Advent Of Code 2020 Day 6 Part 1";

  public function handle() {
    $groups = $this->_readGroupedInput();
    print_r($groups);
    echo "\n";

    $sum = 0;
    foreach ($groups as $group) {
      $yesses = [];
      foreach ($group as $person) {
        foreach (str_split($person) as $answer) {
          if (isset($yesses[$answer])) {
            $yesses[$answer]++;
          } else {
            $yesses[$answer] = 1;
          }
        }
      }
      $sum += count($yesses);
    }
    echo "sum: " . $sum . "\n";
  }
}
