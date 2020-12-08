<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\Commands\Advent\AdventBase;

class Day8Part1 extends AdventBase {

  protected $signature = "year2020:day8part1";
  protected $description = "Advent Of Code 2020 Day 8 Part 1";
  protected $_memory = [];
  protected $_initialMemory = [];

  public function handle() {
    $lines = $this->_readInput();
    $hasVisited = [];

    $pc = 0;
    $acc = 0;
    while(!isset($hasVisited[$pc])) {
      echo "executing $pc\n";
      print_r($hasVisited);
      echo "\n";
      $hasVisited[$pc] = true;

      list($op, $arg) = explode(' ', $lines[$pc]);
      preg_match('/(\+|\-)(\d+)/', $arg, $matches);
      $direction = $matches[1];
      $amount = $matches[2];

      switch ($op) {
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
          echo "bad line: $lines[$pc]\n";
          exit -1;
      }
    }
    echo "accumulator: $acc\n";
  }
}
