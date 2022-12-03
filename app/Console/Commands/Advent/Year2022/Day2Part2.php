<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2022;

use App\Console\AdventBase;

class Day2Part2 extends AdventBase
{
  protected $signature = 'year2022:day2part2';
  protected $description = 'Advent of Code 2022 Day 2 Part 1';

  public function handle() {
    $lines = $this->_readInput();
    $values = [
      'A' => 1,
      'B' => 2,
      'C' => 3,
      'X' => 1,
      'Y' => 2,
      'Z' => 3,
    ];
    $loser = [
      'A' => 'C',
      'B' => 'A',
      'C' => 'B',
    ];
    $winner = [
      'A' => 'B',
      'B' => 'C',
      'C' => 'A',
    ];
    $scores = [
      1 => 6,
      2 => 0,
      0 => 3,
    ];
    $sum = 0;
    foreach ($lines as $line) {
      list($them, $result) = explode(' ', $line);
      if ($result == 'X') {
        // let's lose
        $us = $loser[$them];
      } elseif ($result == 'Y') {
        // let's draw
        $us = $them;
      } elseif ($result == 'Z') {
        // let's win
        $us = $winner[$them];
      } else {
        exit('BOOM');
      }

      $compare = (($values[$us] + 3 - $values[$them]) % 3);
      $sum += ($values[$us] + $scores[$compare]);
    }
    echo "$sum\n";
    return parent::SUCCESS;
  }
}
