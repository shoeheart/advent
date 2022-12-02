<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day18Part2 extends AdventBase {

  protected $signature = "year2020:day18part2";
  protected $description = "Advent Of Code 2020 Day 18 Part 2";

  protected function _eval($expression) {
    $expression = preg_replace('/\(/', '( ', $expression);
    $expression = preg_replace('/\)/', ' )', $expression);
    $tokens = explode(' ', $expression);
    $depth = 0;
    $i = 0;
    $primaryOp = NULL;
    $secondaryOp = NULL;
    $register = NULL;
    foreach($tokens as $token) {
      echo "###################### iteration: $i\n";
      echo "token $token\n";
      echo "before operation:\n";
      print_r($register);
      echo "\n";
      echo "primaryOp:\n";
      print_r($primaryOp ?? 'no prim');
      echo "\n";
      echo "secondaryOp:\n";
      print_r($secondaryOp ?? 'no sec');
      echo "\n";
      switch ($token) {
        case '(':
          $depth++;
          break;
        case '+':
          $primaryOp[$depth] = '+';
          break;
        case '*':
          $secondaryOp[$depth][] = '*';
          break;
        case ')':
          $operated = false;
          if (isset($primaryOp[$depth])) {
            switch ($primaryOp[$depth]) {
              case "+":
                $register[$depth][] = array_pop($register[$depth]) + array_pop($register[$depth]);
                break;
              default:
                echo "invalid primaryOp\n";
                exit;
            }
            unset($primaryOp[$depth]);
          }
          if (isset($secondaryOp[$depth])) {
            foreach($secondaryOp[$depth] as $op) {
              $operated = true;
              switch ($op) {
                case "*":
                  $register[$depth][] = array_pop($register[$depth]) * array_pop($register[$depth]);
                  break;
                default:
                  echo "invalid secondaryOp\n";
                  exit;
              }
            }
            unset($secondaryOp[$depth]);
          }
          $depth--;
          $register[$depth][] = array_pop($register[$depth + 1]);
          // also clear prior level primaryOp if any pending
          if (isset($primaryOp[$depth])) {
            switch ($primaryOp[$depth]) {
              case "+":
                $register[$depth][] = array_pop($register[$depth]) + array_pop($register[$depth]);
                break;
              default:
                echo "invalid primaryOp\n";
                exit;
            }
            unset($primaryOp[$depth]);
          }
          break;

        // intval found is default case
        default:
          if (isset($primaryOp[$depth])) {
            switch ($primaryOp[$depth]) {
              case "+":
                $register[$depth][] = array_pop($register[$depth]) + intval($token);
                break;
              default:
                echo "invalid primaryOp\n";
                exit;
            }
            unset($primaryOp[$depth]);
          } else {
            $register[$depth][] = intval($token);
          }
      }
      $i++;
      echo "end of operation:\n";
      print_r($register);
      echo "\n";
      echo "primaryOp:\n";
      print_r($primaryOp ?? 'no prim');
      echo "\n";
      echo "secondaryOp:\n";
      print_r($secondaryOp ?? 'no sec');
      echo "\n";
    }
    echo "################\n";
    echo "after all tokens processed:\n";
    print_r($register);
    echo "\n";
    echo "primaryOp:\n";
    print_r($primaryOp ?? 'no prim');
    echo "\n";
    echo "secondaryOp:\n";
    print_r($secondaryOp ?? 'no sec');
    echo "\n";
    $sum = 0;
    if (isset($primaryOp[$depth])) {
      $register[$depth][] = array_pop($register[$depth]) + array_pop($register[$depth]);
    }
    echo "remaining register:\n";
    print_r($register);
    echo "\n";
    $acc = 1;
    foreach($register[$depth] as $remaining) {
      $acc *= $remaining;
    }
    return $acc;
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
