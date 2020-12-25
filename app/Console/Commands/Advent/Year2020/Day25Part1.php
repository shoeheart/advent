<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\Commands\Advent\AdventBase;

class Day25Part1 extends AdventBase {

  protected $signature = "year2020:day25part1";
  protected $description = "Advent Of Code 2020 Day 25 Part 1";

  protected function _transform($value, $subjectNumber) {
    $result = $value * $subjectNumber;
    $result = $result % 20201227;
    return $result;
  }

  public function handle() {
    $cardPublicKey = 5764801;
    $doorPublicKey = 17807724;
    $cardPublicKey = 18356117;
    $doorPublicKey = 5909654; // answer: 16902792
    $subjectNumber = 7;

    $value = 1;
    $i = 0;
    while ($value != $cardPublicKey) {
      $value = $this->_transform($value, 7);
      $i++;
    }
    echo "card loop size $i: $value\n";
    $cardLoopSize = $i;

    $value = 1;
    $i = 0;
    while ($value != $doorPublicKey) {
      $value = $this->_transform($value, 7);
      $i++;
    }
    echo "door loop size $i: $value\n";
    $doorLoopSize = $i;

    $value = 1;
    for ($i = 0; $i < $cardLoopSize; $i++) {
      $value = $this->_transform($value, $doorPublicKey);
    }
    echo "card calculated encryption key $value\n";

    $value = 1;
    for ($i = 0; $i < $doorLoopSize; $i++) {
      $value = $this->_transform($value, $cardPublicKey);
    }
    echo "door calculated encryption key $value\n";
  }
}
