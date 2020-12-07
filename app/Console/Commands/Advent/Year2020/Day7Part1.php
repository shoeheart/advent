<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\Commands\Advent\AdventBase;

class Day7Part1 extends AdventBase {

  protected $signature = "year2020:day7part1";
  protected $description = "Advent Of Code 2020 Day 7 Part 1";
  protected $_containers = [];

  public function handle() {
    $rules = $this->_readInput();

    $this->_containers = [];
    foreach ($rules as $rule) {
      list($container, $canHave) = explode( 'bags contain', $rule);
      $container = trim($container);
      $canHave = trim($canHave);
      $canContain = explode(',', $canHave);
      //print_r($container);
      //echo "\n";
      //print_r($canContain);
      //echo "\n";
      if (isset($this->_containers[$container])) {
        echo "container " . $container . " already specified\n";
        exit -1;
      }
      $this->_containers[$container] = [];
      foreach($canContain as $bagSpecification) {
        preg_match('/(no other bags\.)|(\d+)\ (.*)bag.*/', $bagSpecification, $matches);
        //echo "match?\n";
        //print_r($matches);
        //echo "\n";
        if (count($matches) != 4 && count($matches) != 2) {
            echo "bad spec\n";
            print_r($matches);
            echo "\n";
            exit -1;
        }
        if (count($matches) == 4) {
          $this->_containers[$container][trim($matches[3])] = $matches[2];
        } else {
          $this->_containers[$container] = [];
        }
      }
      //print_r($containers[$container]);
      //echo "\n";
    }
    //print_r($this->_containers);
    //echo "\n";

    $sum = 0;
    foreach($this->_containers as $container => $allowed) {
      if ($this->canContain($container, 'shiny gold')) {
        $sum++;
      }
    }
    echo "sum: " . $sum . "\n";
  }

  protected function canContain($container, $bag) {
    $directContents = $this->_containers[$container];
    if (in_array($bag, array_keys($directContents))) {
      return true;
    }
    foreach($directContents as $directContent => $allowed) {
      if ($this->canContain($directContent, $bag)) {
        return true;
      }
    }
    return false;
  }
}