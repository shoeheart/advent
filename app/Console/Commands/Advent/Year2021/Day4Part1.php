<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2021;

use App\Console\AdventBase;

class BoardPart1 {
  private $_board = array();
  private $_called = [
    [0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0],
  ];

  public function addRow($row) {
    array_push($this->_board, preg_split('/\s+/', trim($row)));
  }

  public function call($number) {
    foreach ($this->_board as $rowIndex => $row) {
      echo "looking for $number in " . implode(',', $row) . "\n";
      foreach ($row as $columnIndex => $value) {
        echo "looking for $number in $value at position $columnIndex\n";
        if ($value == $number) {
          echo "$value == $number\n";
          $this->_called[$rowIndex][$columnIndex] = 1;
        }
      }
    }
  }

  public function isWon() {
    foreach ($this->_called as $row) {
      if (
        $row[0] == 1 &&
        $row[1] == 1 &&
        $row[2] == 1 &&
        $row[3] == 1 &&
        $row[4] == 1
      ) {
        return true;
      }
    }
    for ($c = 0; $c < 5; $c++) {
      if (
        $this->_called[0][$c] == 1 &&
        $this->_called[1][$c] == 1 &&
        $this->_called[2][$c] == 1 &&
        $this->_called[3][$c] == 1 &&
        $this->_called[4][$c] == 1
      ) {
        return true;
      }
    }
  }

  public function unmarkedNumbers() {
    $unmarked = [];
    foreach ($this->_called as $row => $calledRow) {
      foreach ($calledRow as $column => $calledColumn) {
        if ($calledColumn == 0) {
          $unmarked[]= $this->_board[$row][$column];
        }
      }
    }
    return $unmarked;
  }

  public function print() {
    foreach ($this->_board as $row) {
      echo implode(" ", $row) . "\n";
    }
    echo "\n";
    foreach ($this->_called as $row) {
      echo implode(" ", $row) . "\n";
    }
    echo "\n";
  }
}

class Day4Part1 extends AdventBase {

  protected $signature = "year2021:day4part1";
  protected $description = "Advent Of Code 2021 Day 4 Part 1";


  public function handle() {
    $lines = $this->_readInput();
    $boards = array();
    $calls = explode(',', $lines[0]);
    echo "calls = " . implode(',', $calls) . "\n";
    $i = 2;
    while ($i <= (count($lines) - 2)) {
      // grab 5 lines to make a board
      $board = new BoardPart1();
      for ($j = $i; $j < $i + 5; $j++) {
        $board->addRow($lines[$j]);
      }
      $boards[] = $board;
      $i += 6;
    }

    foreach ($boards as $board) {
      $board->print();
    }

    foreach ($calls as $call) {
      // echo "searching for $call\n";
      foreach ($boards as $board) {
        $board->call($call);
        if ($board->isWon()) {
          echo "winning board:\n";
          echo $board->print();
          echo print_r($board->unmarkedNumbers(), true);
          echo array_sum($board->unmarkedNumbers()) . "\n";
          echo array_sum($board->unmarkedNumbers()) * $call . "\n";
          exit;
        }
      }
    }

    foreach ($boards as $board) {
      $board->print();
    }
  }
}
