<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2022;

use App\Console\AdventBase;

class Day3Part1 extends AdventBase
{
  protected $signature = 'year2022:day3part1';
  protected $description = 'Advent of Code 2022 Day 3 Part 1';

  public static function priority($item) {
    if (ord($item) >= ord('a') && ord($item) <= ord('z')) {
      return (ord($item) - ord('a') + 1);
    } else {
      return (ord($item) - ord('A') + 27);
    }
  }

  public function handle()
  {
    $lines = $this->_readInput();
    $sum = 0;
    foreach ($lines as $line) {
      $sack = str_split($line);
      $halfCount = count($sack) / 2;
      $firstHalf = array_slice($sack, 0, $halfCount);
      $secondHalf = array_slice($sack, $halfCount, $halfCount);
      $overlap = array_intersect($firstHalf, $secondHalf);
      $item = array_values(array_unique($overlap))[0];
      $sum += static::priority($item);
    }
    echo "$sum\n";
    return parent::SUCCESS;
  }
}
