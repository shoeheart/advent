<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2022;

use App\Console\AdventBase;

class Day5Part2 extends AdventBase
{
  protected $signature = 'year2022:day5part2';
  protected $description = 'Advent of Code 2022 Day 5 Part 2';
  protected $stacks = null;

  public function move($count, $from, $to) {
    $temp = array();
    for ($i = 0; $i < $count; $i++) {
      array_push($temp, array_pop($this->stacks[$from - 1]));
    }
    array_reverse($temp);
    for ($i = 0; $i < $count; $i++) {
      array_push($this->stacks[$to - 1], array_pop($temp));
    }
  }

  public function handle()
  {
    $lines = $this->_readInput();
    $stackCount = (strlen($lines[0]) + 1) / 4;
    $this->stacks = array_fill(0, $stackCount, []);
    $instructionsStartAt = 0;
    foreach ($lines as $line) {
      $instructionsStartAt++;
      // skip line that says how many stack we have and start with next
      if (false == str_contains($line, "[")) {
        $instructionsStartAt++;
        break;
      }
      $stackChunks = array_chunk(str_split($line), 4);
      foreach($stackChunks as $stackIndex => $stack) {
        if ($stack[1] != ' ') {
          $this->stacks[$stackIndex][] = $stack[1];
        }
      }
    }
    // reverse so we can use push/pop
    foreach($this->stacks as $stackIndex => $stack) {
      $this->stacks[$stackIndex] = array_reverse($stack);
    }
    $moves = array_slice($lines, $instructionsStartAt);
    foreach ($moves as $move) {
      list($ignore, $count, $ignore, $from, $ignore, $to) = explode(' ', $move);
      static::move($count, $from, $to);
    }
    $final = "";
    foreach($this->stacks as $stack) {
      $final = $final . array_pop($stack);
    }
    echo "$final\n";

    return parent::SUCCESS;
  }
}
