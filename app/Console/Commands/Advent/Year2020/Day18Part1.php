<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day18Part1 extends AdventBase {

  protected $signature = "year2020:day18part1";
  protected $description = "Advent Of Code 2020 Day 18 Part 1";

  protected function _eval($expression) {
    $expression = preg_replace('/\(/', '( ', $expression);
    $expression = preg_replace('/\)/', ' )', $expression);
    $tokens = explode(' ', $expression);
    $depth = 0;
    foreach($tokens as $token) {
      switch ($token) {
        case '(':
          $depth++;
          break;
        case '+':
          $currentOp[$depth] = '+';
          break;
        case '*':
          $currentOp[$depth] = '*';
          break;
        case ')':
          $token = $register[$depth];
          unset($register[$depth]);
          $depth--;
        default:
          if (isset($currentOp[$depth])) {
            switch ($currentOp[$depth]) {
              case "*":
                $register[$depth] = $register[$depth] * intval($token);
                break;
              case "+":
                $register[$depth] = $register[$depth] + intval($token);
                break;
            }
            unset($currentOp[$depth]);
          } else {
            $register[$depth] = intval($token);
          }
      }
    }
    return $register[$depth];
  }

  public function handle() {
    $lines = $this->_readInput();
    $problems = [];

    foreach($lines as $line) {
      $problems[] = $line;
    }

    //print_r($problems);
    //echo "\n";

    $sum = 0;
    foreach($problems as $problem) {
      echo "expression: " . $problem . "\n";
      $result = $this->_eval($problem);
      $sum += $result;
      echo "  result: $result\n";
    }
    echo "sum: $sum\n";
  }
}
