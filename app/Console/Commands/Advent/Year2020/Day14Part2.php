<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day14Part2 extends AdventBase {

  protected $signature = "year2020:day14part2";
  protected $description = "Advent Of Code 2020 Day 14 Part 2";
  protected $_lines = [];
  protected $_memory = [];

  protected function _writeFloatedAddress($decimalAddress, $floats, $value) {
    //echo "################\nwriteFloatedAddress\n";
    $binaryAddress = decbin($decimalAddress);
    $binaryAddress = str_pad($binaryAddress, 36, '0', STR_PAD_LEFT);
    //print_r($binaryAddress);
    //echo "\n";
    //print_r($floats);
    //echo "\n";
    if (empty($floats)) {
      //echo "write address $binaryAddress!!!\n";
      $this->_memory[bindec($binaryAddress)] = $value;
    } else {
      $floatIndex = $floats[0];
      $rest = array_slice($floats, 1);
      //echo "rest:\n";
      //print_r($rest);
      //echo "\n";
      $this->_writeFloatedAddress(bindec(substr_replace($binaryAddress, 0, $floatIndex, 1)), $rest, $value);
      $this->_writeFloatedAddress(bindec(substr_replace($binaryAddress, 1, $floatIndex, 1)), $rest, $value);
    }
  }

  protected function _mask($address, $overwrites) {
    //echo "masking $address\n";
    //echo "overwrites\n";
    //print_r($overwrites);
    //echo "\n";
    $binaryAddress = decbin($address);
    $binaryAddress = str_pad($binaryAddress, 36, '0', STR_PAD_LEFT);
    //echo "masking $binaryAddress\n";
    foreach($overwrites as $position => $replacementValue) {
      if ($replacementValue == 1) {
        $binaryAddress = substr_replace($binaryAddress, $replacementValue, $position, 1);
      }
    }
    //echo "result  $binaryAddress\n";
    //echo "result " . bindec($binaryAddress) . "\n";
    return bindec($binaryAddress);
  }


  //   // build list of all addresses to update
  //   foreach($floats as $floatIndex) {
  //     array_slice($remainingFloats, 1)
  //     $address1 = subs
  //     $addresses = $this->_floatTheseAddresses($addresses);
  //     $addresses = $this->_floatTheseAddresses($addresses);

  //     $base0 = substr_replace($binaryAddress, 0, $floatIndex, 1);
  //     $base1 = substr_replace($binaryAddress, 1, $floatIndex, 1);

  //   }

  //     $this->_write($address, $value);


  // }

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
        $overwrites = [];
        $floats = [];
        //print_r($matches);
        //echo "\n";
        foreach(str_split($matches[1]) as $index => $bit) {
          if ($bit == '1' ) {
            $overwrites[$index] = $bit;
          } elseif ($bit == 'X') {
            $floats[] = $index;
          }
        }
        $lines[] = array(
          'command' => 'mask',
          'overwrites' => $overwrites,
          'floats' => $floats,
        );
      } else {
        echo "bad!!!: $line\n";
      }
    }
    //print_r($lines);
    //echo "\n";

    foreach($lines as $instruction) {
      if ($instruction['command'] == 'mask') {
        $currentMask = $instruction;
      } elseif ($instruction['command'] == 'write') {
        if (!isset($currentMask)) {
          echo "write without set mask: " . print_r($instruction, true) . "\n";
          exit -1;
        }
        $maskedFloatableAddress =
          $this->_mask($instruction['address'], $currentMask['overwrites']);

        $this->_writeFloatedAddress(
          $maskedFloatableAddress,
          $currentMask['floats'],
          $instruction['value']
        );
      }
    }

    $sum = 0;
    foreach($this->_memory as $index => $value) {
      //echo "binaryAddress: " . decbin($index) . "\n";
      $sum += $value;
    }
    //print_r($this->_memory);
    //echo "\n";
    echo "answer: $sum\n";
  }
}
