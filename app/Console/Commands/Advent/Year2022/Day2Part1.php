<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2022;

// use Illuminate\Console\Command;
use App\Console\AdventBase;

class Day2Part1 extends AdventBase
{
  protected $signature = 'year2022:day2part1';
  protected $description = 'Advent of Code 2022 Day 2 Part 1';

  public function handle() {
    $lines = $this->_readInput();
    $score = 0;
    $values = [
      'A' => 1,
      'B' => 2,
      'C' => 3,
      'X' => 1,
      'Y' => 2,
      'Z' => 3,
    ];
    $scores = [
      1 => 6,
      2 => 0,
      0 => 3,
    ];
    $sum = 0;
    foreach ($lines as $line) {
      list($them, $us) = explode(' ', $line);
      $compare = (($values[$us] + 3 - $values[$them]) % 3);
      // echo "$compare\n";
      $sum += ($values[$us] + $scores[$compare]);
    }
    echo "$sum\n";
    return parent::SUCCESS;
  }
}
