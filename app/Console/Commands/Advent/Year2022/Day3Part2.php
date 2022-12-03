<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2022;

use App\Console\AdventBase;

class Day3Part2 extends AdventBase
{
  protected $signature = 'year2022:day3part2';
  protected $description = 'Advent of Code 2022 Day 3 Part 2';

  public static function priority($item) {
    if (ord($item) >= ord('a') && ord($item) <= ord('z')) {
      return (ord($item) - ord('a') + 1);
    } else {
      return (ord($item) - ord('A') + 27);
    }
  }

  public function handle() {
    $lines = $this->_readInput();
    $sum = 0;
    foreach (array_chunk($lines, 3) as $elfGroup) {
      $sum +=
        static::priority(
          array_values(
            array_unique(
              array_intersect(
                str_split($elfGroup[0]),
                str_split($elfGroup[1]),
                str_split($elfGroup[2])
              )
            )
          )[0]
        );
    }
    echo "$sum\n";
    return parent::SUCCESS;
  }
}
