<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2023;

// use Illuminate\Console\Command;
use App\Console\AdventBase;

class Day1Part2 extends AdventBase
{
  protected $signature = 'year2023:day1part2';
  protected $description = 'Advent of Code 2023 Day 1 Part 2';

  public function handle() {
    $lines = $this->_readInput();
    $sum = 0;
    $wordToNumberMap = array(
      'one' => 1,
      'two' => 2,
      'three' => 3,
      'four' => 4,
      'five' => 5,
      'six' => 6,
      'seven' => 7,
      'eight' => 8,
      'nine' => 9
    );
    $valuesToMatch = array_keys($wordToNumberMap);

    foreach ($lines as $line) {

      echo "starting line: " . $line . "\n";
      do {
        $firstMatch = null;
        $position = -1;

        foreach ($valuesToMatch as $value) {
          $pos = strpos($line, $value);
          if ($pos !== false && ($position === -1 || $pos < $position)) {
              $firstMatch = $value;
              $position = $pos;
          }
        }

        echo "line: " . $line . "\n";
        echo "firstMatch: " . $firstMatch . "\n";
        echo "position: " . $position . "\n";

        if ($firstMatch != null) {
          $line = substr_replace(
            $line,
            (string)$wordToNumberMap[$firstMatch] . substr($firstMatch, 1),
            $position,
            strlen($firstMatch)
        );
        } else {
          break;
        }
        echo "new line: " . $line . "\n";

      } while (true);

      echo "final line: " . $line . "\n";

      preg_match_all('/\d/', $line, $matches);

      $firstInteger = $matches[0][0];
      $lastInteger = end($matches[0]);
      echo $firstInteger . $lastInteger . "\n";
      $combinedInteger = (int)($firstInteger . $lastInteger);
      $sum += $combinedInteger;
    }
    echo "sum: $sum\n";

    return parent::SUCCESS;
  }
}
