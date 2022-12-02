<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2021;

use App\Console\AdventBase;

class Day10Part1 extends AdventBase {

  protected $signature = "year2021:day10part1";
  protected $description = "Advent Of Code 2021 Day 10 Part 1";

  const OPENERS = array(
    '(' => ')',
    '[' => ']',
    '{' => '}',
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
    $score = 0;
    for ($i = 0; $i < count($lines); $i++) {
      echo "Analyzing line $i: " . $lines[$i] . "\n";
      $stack = new \Ds\Stack();
      $result = "passed";
      foreach(str_split($lines[$i]) as $token) {
        // echo "have $token\n";
        if (in_array($token, array_keys(self::OPENERS))) {
          // echo "pushing $token\n";
          $stack->push($token);
        } elseif (self::OPENERS[$stack->peek()] == $token) {
          // echo "popping " . $stack->peek() . "\n";
          $stack->pop();
        } else {
          echo "Bad token: $token, score: " . self::CLOSERS[$token] . "\n";
          $score += self::CLOSERS[$token];
          $result = "failed";
          break;
        }
      }
      echo "Line $result!!!\n";
    }
    echo "score: $score\n";
  }
}
