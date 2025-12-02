<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2025;

use App\Console\AdventBase;

class Day1Part1 extends AdventBase
{
  protected $signature = 'year2025:day1part1';
  protected $description = 'Advent of Code 2025 Day 1 Part 1';

  public function handle() {
    $lines = $this->_readInput();

    // Your solution code here

    return parent::SUCCESS;
  }
}
