<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2023;

// use Illuminate\Console\Command;
use App\Console\AdventBase;

class Day1Part1 extends AdventBase
{
  protected $signature = 'year2023:day1part1';
  protected $description = 'Advent of Code 2023 Day 1 Part 1';

  public function handle() {
    $lines = $this->_readInput();
    $sum = 0;
    foreach ($lines as $line) {
      preg_match_all('/\d/', $line, $matches);

      $firstInteger = $matches[0][0];
      $lastInteger = end($matches[0]);
      echo $firstInteger . $lastInteger . "\n";
      $combinedInteger = (int)($firstInteger . $lastInteger);
      $sum += $combinedInteger;
    }
    echo "sum: $sum\n";

    return parent::SUCCESS;
  }
}
