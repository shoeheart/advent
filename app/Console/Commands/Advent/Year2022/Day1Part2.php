<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2022;

// use Illuminate\Console\Command;
use App\Console\AdventBase;

class Day1Part2 extends AdventBase
{
  protected $signature = 'year2022:day1part2';
  protected $description = 'Advent of Code Year 2022 Day 1 Part 2';

  public function handle() {
    $lines = $this->_readInput();
    $elfCalories = [];
    $elfCalories[] = 0;
    $currentElf = 0;
    foreach ($lines as $line) {
      if (empty($line)) {
        $currentElf++;
        $elfCalories[] = 0;
      } else {
        $elfCalories[$currentElf] += intval($line);
      }
    }
    print_r($elfCalories);
    sort($elfCalories);
    print_r($elfCalories);
    $topCalories = array_reverse($elfCalories);
    print_r($topCalories);
    $top3calories = $topCalories[0] + $topCalories[1] + $topCalories[2];
    echo "top 3 elves contain total $top3calories\n";

    return parent::SUCCESS;
  }
}
