<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2021;

use App\Console\Commands\Advent\AdventBase;

class Day10Part2 extends AdventBase {

  protected $signature = "year2021:day10part2";
  protected $description = "Advent Of Code 2021 Day 10 Part 2";

  const OPENERS = array(
    '(' => ')',
    '[' => ']',
    '{' => '}',
    '<' => '>',
  );

  const CLOSERS = array(
    ')' => 1,
    ']' => 2,
    '}' => 3,
    '>' => 4,
  );

  public function handle() {
    $lines = $this->_readInput();
    $scores = [];
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
          $result = "failed";
          break;
        }
      }
      if ($result == "passed") {
        $score = 0;
        while (!$stack->isEmpty()) {
          $token = $stack->pop();
          $score = ($score * 5) + self::CLOSERS[self::OPENERS[$token]];
        }
        echo "score: $score\n";
        $scores[] = $score;
      }
      echo "Line $result!!!\n";
    }
    sort($scores);
    echo "scores: " . print_r($scores, true) . "\n";
    // echo count($scores) . "\n";
    // echo intdiv(count($scores), 2) . "\n";
    echo "middle: " . $scores[intdiv(count($scores), 2)] . "\n";
  }
}
