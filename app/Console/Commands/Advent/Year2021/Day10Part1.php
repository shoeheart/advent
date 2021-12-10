<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2021;

use App\Console\Commands\Advent\AdventBase;

class Day10Part1 extends AdventBase {

  protected $signature = "year2021:day10part1";
  protected $description = "Advent Of Code 2021 Day 10 Part 1";

  const OPENERS = array(
    '(' => ')',
    '[' => ']',
    '{' => ')',
    '<' => '>',
  );

  const CLOSERS = array(
    ')' => 3,
    ']' => 57,
    '}' => 1197,
    '>' => 25137,
  );

  public function handle() {
    $lines = $this->_readInput();
    for ($i = 0; $i < count($lines); $i++) {
      $stack = new \Ds\Stack();
      foreach($lines[$i] as $token) {
        if (in_array($token, self::OPENERS)) {
          $stack->push($token);
        } else if (self::OPENERS[$stack->peek()] == $token) {
          $stack->pop();
        } else {
          echo "Bad token: $token\n";
        }
      }
    }
  }
}
