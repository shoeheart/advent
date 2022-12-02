<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day2Part1 extends AdventBase {

  protected $signature = "year2020:day2part1";
  protected $description = "Advent Of Code 2020 Day 2 Part 1";

  public function handle() {
    $policies = $this->_readInput();

    $bad = 0;
    $good = 0;
    for ($i = 0; $i < count($policies); $i++) {
      $segments = explode(' ', $policies[$i]);
      $limits = explode('-', $segments[0]);
      $low = $limits[0];
      $high = $limits[1];
      $letter = explode(':', $segments[1])[0];
      $password = $segments[2];
      $count = substr_count($password, $letter);
      if ($count >= $low && $count <= $high) {
        $good++;
      } else {
        $bad++;
      }
    }
    echo "good: " . $good . "\n";
    echo "bad: " . $bad . "\n";
  }
}

