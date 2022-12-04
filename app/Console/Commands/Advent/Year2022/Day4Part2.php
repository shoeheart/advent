<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2022;

use App\Console\AdventBase;

class Day4Part2 extends AdventBase
{
  protected $signature = 'year2022:day4part2';
  protected $description = 'Advent of Code 2022 Day 4 Part 2';

  public function handle()
  {
    $lines = $this->_readInput();
    $overlapsCount = 0;
    foreach ($lines as $line) {
      list($left, $right) = explode(',', $line);
      list($leftLow, $leftHigh) = explode('-', $left);
      list($rightLow, $rightHigh) = explode('-', $right);
      $leftRange = range($leftLow, $leftHigh);
      $rightRange = range($rightLow, $rightHigh);
      if (array_intersect($leftRange, $rightRange)) {
        $overlapsCount++;
      }
    }
    echo "$overlapsCount\n";
    return parent::SUCCESS;
  }
}
