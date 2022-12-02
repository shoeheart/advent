<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2022;

// use Illuminate\Console\Command;
use App\Console\AdventBase;

class Day1Part1 extends AdventBase
{
  protected $signature = 'year2022:day1part1';
  protected $description = 'Advent of Code Year 2022 Day 1 Part 1';

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
    $highestElf = -1;
    $highestCalories = $elfCalories[0];
    foreach ($elfCalories as $currentElf => $elfCalorie) {
      if ($elfCalorie > $highestCalories) {
        $highestElf = $currentElf;
        $highestCalories = $elfCalorie;
      }
    }
    echo "zero-based elf $highestElf has highest number of calories with $highestCalories\n";



    return parent::SUCCESS;
  }
}
