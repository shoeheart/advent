<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\Commands\Advent\AdventBase;

class Day14Part1 extends AdventBase {

  protected $signature = "year2020:day14part1";
  protected $description = "Advent Of Code 2020 Day 14 Part 1";
  protected $_lines = [];

  protected function _mask($mask, $decimalInput) {
    // echo "masking decimal $decimalInput\n";
    $binaryString = decbin($decimalInput);
    // echo "masking binary $binaryString\n";
    $binaryString = str_pad($binaryString, 36, '0', STR_PAD_LEFT);
    // echo "masking binary $binaryString\n";
    foreach($mask as $position => $replacementValue) {
      //echo "$position, $replacementValue\n";
      $binaryString = substr_replace($binaryString, $replacementValue, $position, 1);
      //print_r($input);
      //echo "\nmasked!!!\n";
    }
    // echo "returning $binaryString\n";
    return $binaryString;
  }

  public function handle() {
    $raw = $this->_readInput();
    $lines = [];
    foreach($raw as $line) {
      //print_r($line);
      //echo "\n";
      if(preg_match('/mem\[(\d+)\] = (\d+)/', $line, $matches)) {
        $lines[] = array(
          'command' => 'write',
          'address' => $matches[1],
          'value' => $matches[2]
        );
      } elseif (preg_match('/mask = ([X01]+)/', $line, $matches)) {
        $mask = [];
        foreach(str_split($matches[1]) as $index => $bit) {
          if ($bit != 'X') {
            $mask[$index] = $bit;
          }
        }
        $lines[] = array(
          'command' => 'mask',
          'mask' => $mask
        );
        //echo "MASK TEST\n";
        //$str = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
        //$str = $this->_mask($mask, $str);
        //echo "masked: $str\n";
        //echo "as decimal: " . bindec($str) . "\n";
      } else {
        echo "bad!!!: $line\n";
      }
      //print_r($matches);
      //echo "\n";
    }
    //print_r($lines);
    //echo "\n";

    $memory = [];
    foreach($lines as $instruction) {
      if ($instruction['command'] == 'mask') {
        $currentMask = $instruction['mask'];
      } elseif ($instruction['command'] == 'write') {
        if (!isset($currentMask)) {
          echo "write without set mask: " . print_r($instruction, true) . "\n";
          exit -1;
        }
        $valueToMask = $instruction['value'];
        $response = $this->_mask($currentMask, $valueToMask);
        $memory[$instruction['address']] =
          bindec($this->_mask($currentMask, $valueToMask));
      } else {
        echo "bad instruction. " . print_r($instruction, true) . "\n";
        exit -1;
      }
    }
    $sum = 0;
    foreach($memory as $index => $value) {
      $sum += $value;
    }
    echo "answer: $sum\n";
  }
}
