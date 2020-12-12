<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\Commands\Advent\AdventBase;

class Day8Part2 extends AdventBase {

  protected $signature = "year2020:day8part2";
  protected $description = "Advent Of Code 2020 Day 8 Part 2";
  protected $_initialCode = [];

  public function handle() {
    $this->_initialCode = $this->_readInput();

    foreach($this->_initialCode as $lineNumber => $assembly) {
      $code = $this->_initialCode;
      if (substr($assembly, 0, 3) == 'nop') {
        $code[$lineNumber] = 'jmp' . substr($assembly, 3);
        echo "changed $lineNumber to " . $code[$lineNumber] . "\n";
      } elseif (substr($assembly, 0, 3) == 'jmp') {
        $code[$lineNumber] = 'nop' . substr($assembly, 3);
        echo "changed $lineNumber to " . $code[$lineNumber] . "\n";
      } else {
        echo "skipped $lineNumber " . $code[$lineNumber] . "\n";
        continue;
      }

      if ($this->compute($code)) {
        return;
      }
    }
  }

  protected function compute($code) {
    $pc = 0;
    $acc = 0;
    $hasVisited = [];
    while($pc < count($code) && !isset($hasVisited[$pc])) {
      // echo "executing $pc\n";
      // print_r($hasVisited);
      // echo "\n";
      $hasVisited[$pc] = true;

      list($op, $arg) = explode(' ', $code[$pc]);
      preg_match('/(\+|\-)(\d+)/', $arg, $matches);
      $direction = $matches[1];
      $amount = $matches[2];

      switch($op) {
        case 'acc':
          if ($direction == '+') {
            $acc += $amount;
          } else {
            $acc -= $amount;
          }
          $pc++;
        break;
        case 'jmp':
          if ($direction == '+') {
            $pc += $amount;
          } else {
            $pc -= $amount;
          }
        break;
        case 'nop':
          $pc++;
        break;
        default:
          echo "bad line at $pc: $code[$pc]\n";
          exit -1;
      }
    }
    if ($pc == count($code)) {
      echo "successful termination\n";
      echo "accumulator: $acc\n";
      return true;
    } else {
      echo "broke infinite loop with pc = $pc\n";
      echo "accumulator: $acc\n";
      return false;
    }
  }
}
