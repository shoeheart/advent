<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day23Part1 extends AdventBase {

  protected $signature = "year2020:day23part1";
  protected $description = "Advent Of Code 2020 Day 23 Part 1";

  public function handle() {
    $lines = $this->_readInput();
    $line = $lines[0];
    $cups = str_split($line);
    echo "cups: " . implode('', $cups) . "\n";

    for($i = 0; $i < 100; $i++) {
      $current = array_shift($cups);
      $pickups = array_slice($cups, 0, 3);
      $cups = array_slice($cups, 3);
      echo "current $current\n";
      echo "pickup: " . implode(',', $pickups) . "\n";
      //echo "\npickups\n";
      //print_r($pickups);
      //echo "\ncups\n";
      //print_r($cups);

      $found = false;
      $seeking = $current - 1;
      $highestValue = $current;
      $highestIndex = 0;
      while (! $found && $seeking > -1) {
        foreach($cups as $destinationIndex => $cup) {
          //echo "checking $cup\n";
          if ($cup == $seeking) {
            //echo "found!\n";
            $found = true;
            break;
          } else {
            if ($cup > $highestValue) {
              $highestValue = $cup;
              $highestIndex = $destinationIndex;
            }
          }
        }
        $seeking = $seeking - 1;
      }

      if (! $found) {
        // revert to destination being highest remaining value
        //echo "overriding $destinationIndex to $highestIndex\n";
        if ($highestValue == $current) {
          echo "BOOM\n";
          exit -1;
        } else {
          $destinationIndex = $highestIndex;
        }
      }

      echo "destination: " . $cups[$destinationIndex] . "\n";
      //echo "destinationIndex: $destinationIndex\n";
      if ($destinationIndex > 0) {
        $preDestination = array_slice($cups, 0, $destinationIndex);
      } else {
        $preDestination = [];
      }
      //echo "preDestination\n";
      //print_r($preDestination);
      $destination = $cups[$destinationIndex];
      //echo "destination: $destination\n";
      $remainingCups = array_slice($cups, $destinationIndex + 1);
      //echo "remainingCups\n";
      //print_r($remainingCups);
      $cups =
        array_merge(
          $preDestination,
          array($destination),
          $pickups,
          $remainingCups,
          array($current)
        );
      echo "cups result: " . implode('', $cups) . "\n";
    }

    $found = false;
    while(! $found)  {
      $first = array_shift($cups);
      if ($first == 1) {
        echo "answer: " . implode('', $cups);
        $found = true;
      } else {
        $cups = array_merge($cups, array($first));
      }
    }
  }
}
