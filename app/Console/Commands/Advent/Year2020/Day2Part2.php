<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day2Part2 extends AdventBase {

  protected $signature = "year2020:day2part2";
  protected $description = "Advent Of Code 2020 Day 2 Part 2";

  public function handle() {
    $policies = $this->_readInput();

    $bad = 0;
    $good = 0;
    for ($i = 0; $i < count($policies); $i++) {
      // echo "i: " . $i . "\n";
      $segments = explode(' ', $policies[$i]);
      $limits = explode('-', $segments[0]);
      $low = $limits[0];
      $high = $limits[1];
      $letter = explode(':', $segments[1])[0];
      $password = $segments[2];
      $count = substr_count($password, $letter);
      if (
          (
            (
              (strlen($password) >= ($low - 1)) &&
              $password[$low - 1] == $letter
            )
            &&
            (
              (strlen($password) >= ($high - 1)) &&
              $password[$high - 1] != $letter
            )
          )
          ||
          (
            (
              (strlen($password) >= ($low - 1)) &&
              $password[$low - 1] != $letter
            )
            &&
            (
              (strlen($password) >= ($high - 1)) &&
              $password[$high - 1] == $letter
            )
          )
        ) {
        $good++;
        echo "good[" . $i . "]: " . $policies[$i] . "\n";
      } else {
        $bad++;
        echo "bad[" . $i . "]: " . $policies[$i] . "\n";
      }
    }
    echo "good: " . $good . "\n";
    echo "bad: " . $bad . "\n";
  }
}
