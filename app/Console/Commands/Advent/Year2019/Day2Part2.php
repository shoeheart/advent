<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2019;

use App\Console\Commands\Advent\AdventBase;

class Day2Part2 extends AdventBase {

  protected $signature = "year2019:day2part2";
  protected $description = "Advent Of Code 2019 Day 2 Part 2";
  protected $_memory = [];
  protected $_initialMemory = [];

  public function handle() {
    $lines = $this->_readInput();
    // print_r($lines);
    if (count($lines) != 1) {
        echo "Need exactly one input line.  Exiting...\n";
        exit -1;
    }
    $this->_initialMemory = explode(',', $lines[0]);

    for ($noun = 0; $noun < 100; $noun++) {
      for ($verb = 0; $verb < 100; $verb++) {
        $this->_memory = $this->_initialMemory;
        $this->_memory[1] = $noun;
        $this->_memory[2] = $verb;
        $result = $this->compute();
        if ($result == 19690720) {
            echo "noun: " . $noun . "\n";
            echo "verb: " . $verb . "\n";
            echo "answer:" . 100 * $noun + $verb . "\n";
        }
      }
    }
  }

  protected function compute() {
    $pc = 0;
    while(true) {
      // echo "pc = " . $pc . "\n";
      // print_r(array_slice($this->_memory, $pc, 4));
      // echo "\n";

      switch($this->_memory[$pc]) {
        case 1:
          $this->additionOperand($pc);
          $pc += 4;
          break;
        case 2:
          $this->multiplicationOperand($pc);
          $pc += 4;
          break;
        case 99:
          return $this->_memory[0];
        default:
          echo "Bad operand: " . $this->_memory[$pc] . "\n";
          exit -1;
      }
    }
  }

  protected function additionOperand($pc) {
    $this->_memory[$this->_memory[$pc + 3]] =
      $this->_memory[$this->_memory[$pc + 1]]
      +
      $this->_memory[$this->_memory[$pc + 2]]
      ;
  }

  protected function multiplicationOperand($pc) {
    $this->_memory[$this->_memory[$pc + 3]] =
      $this->_memory[$this->_memory[$pc + 1]]
      *
      $this->_memory[$this->_memory[$pc + 2]]
      ;
  }
}
