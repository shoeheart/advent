<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2025;

use App\Console\AdventBase;

class Day1Part2 extends AdventBase
{
  protected $signature = 'year2025:day1part2';
  protected $description = 'Advent of Code 2025 Day 1 Part 2';

  public function handle() {
    $lines = $this->_readInput();

    // Your solution code here

    return parent::SUCCESS;
  }
}
