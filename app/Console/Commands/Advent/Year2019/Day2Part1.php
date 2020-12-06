<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2019;

use App\Console\Commands\Advent\AdventBase;

class Day2Part1 extends AdventBase {

  protected $signature = "year2019:day2part1";
  protected $description = "Advent Of Code 2019 Day 2 Part 1";
  protected $_memory = [];

  public function handle() {
    $lines = $this->_readInput();
    // print_r($lines);
    if (count($lines) != 1) {
        echo "Need exactly one input line.  Exiting...\n";
        exit -1;
    }
    $this->_memory = explode(',', $lines[0]);
    print_r($this->_memory);
    $this->_memory[1] = 12;
    $this->_memory[2] = 2;
    print_r($this->_memory);

    $result = $this->compute();
    echo "result: " . $result . "\n";
  }

  protected function compute() {
    $pc = 0;
    while(true) {
      echo "pc = " . $pc . "\n";
      print_r(array_slice($this->_memory, $pc, 4));
      echo "\n";

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
