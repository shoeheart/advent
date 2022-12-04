<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2022;

use App\Console\AdventBase;

class Day4Part1 extends AdventBase
{
  protected $signature = 'year2022:day4part1';
  protected $description = 'Advent of Code 2022 Day 4 Part 1';

  public static function contained($leftLow, $leftHigh, $rightLow, $rightHigh) {
    if ($leftLow <= $rightLow && $leftHigh >= $rightHigh) return true;
    if ($rightLow <= $leftLow && $rightHigh >= $leftHigh) return true;
    return false;
  }

  public function handle()
  {
    $lines = $this->_readInput();
    $containsCount = 0;
    foreach ($lines as $line) {
      list($left, $right) = explode(',', $line);
      list($leftLow, $leftHigh) = explode('-', $left);
      list($rightLow, $rightHigh) = explode('-', $right);
      echo "$leftLow - $leftHigh, $rightLow - $rightHigh\n";
      if (static::contained($leftLow, $leftHigh, $rightLow, $rightHigh)) {
        $containsCount++;
      }
    }
    echo "$containsCount\n";
    return parent::SUCCESS;
  }
}
