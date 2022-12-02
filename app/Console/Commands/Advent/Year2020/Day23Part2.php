<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day23Part2 extends AdventBase {

  protected $signature = "year2020:day23part2";
  protected $description = "Advent Of Code 2020 Day 23 Part 2";

  public function handle() {
    ini_set('memory_limit', '16384M');

    $initial = str_split('389547612');
    //$initial = str_split('389125467');

    $max = 1000000;

    $cups = [];
    foreach($initial as $index => $value) {
      if ($index == 0) {
        // first position in initial list must loop back to end of list
        // and forward to next position in initial list
        $cups[$value] =
          array('p' => $max, 'n' => $initial[$index + 1]);
        $current = $value;
      } elseif ($index == (count($initial) - 1)) {
        // last position in initial list must loop back to previous value
        // and forward to next generated number which we know is 10
        $cups[$value] =
          array('p' => $initial[$index - 1], 'n' => max($initial) + 1);
        $lastInitialValue = $value;
      } else {
        // interim initial values just linkt to previous and next
        // value in initial
        $cups[$value] =
          array('p' => $initial[$index - 1], 'n' => $initial[$index + 1]);
        // echo "just set\n" . print_r($cups[$value], true) . "\n";
      }
    }

    // spot right after initial list points back to last initial and forward to
    // next higher generated number
    $cups[max($initial) + 1] =
      array('p' => $lastInitialValue, 'n' => max($initial) + 2);

    foreach(range(max($initial) + 2, $max - 1) as $filler) {
      $cups[$filler] = array('p' => $filler - 1, 'n' => $filler + 1);
    }

    // last spot for $max points back to previous value and forward
    // to first value in $initial
    $cups[$max] =
      array('p' => $max - 1, 'n' => $initial[0]);

    //print_r($cups);

    $rounds = 10000000;
    //$rounds = 5;

    for ($i = 1; $i <= $rounds; $i++) {
      if (($i % 100) == 0) {
        echo "ROUND: $i (" . ((100.0 * $i) / $rounds) . "%)\n";
      }

      $pickup1 = $cups[$current]['n'];
      $pickup2 = $cups[$pickup1]['n'];
      $pickup3 = $cups[$pickup2]['n'];
      $afterPickup3 = $cups[$pickup3]['n'];

      // point current cup to cup following third pickup cup
      // (don't bother updating pickup1 previous and pickup3 next yet
      // since they're effectively out of the list right now
      // and we'll find out soon where they get put back in
      $cups[$afterPickup3]['p'] = $current;
      $cups[$current]['n'] = $afterPickup3;

    //echo "with pickups pulled out\n";
    //print_r($cups);

      // now find destination
      $pickups = array($pickup1, $pickup2, $pickup3);
      //print_r($pickups);
      $destination = $current - 1;
      //echo "seeking $destination\n";
      while ($destination > 0) {
        if (in_array($destination, $pickups)) {
          //echo "found $destination in_array\n";
          $destination--;
        } else {
          //echo "breaking\n";
          break;
        }
      }

      //echo "destination: $destination\n";
      if ($destination == 0) {
        //echo "override destination: $max\n";
        $destination = $max;
      }

      // place pickups after destination cup
      $destinationPriorNext = $cups[$destination]['n'];
      $cups[$destination]['n'] = $pickup1;
      $cups[$pickup1]['p'] = $destination;
      $cups[$pickup3]['n'] = $destinationPriorNext;
      $cups[$destinationPriorNext]['p'] = $pickup3;

      // move to next cup
      $current = $cups[$current]['n'];
    }

    //echo "after\n";
    //echo "current: $current\n";

    //print_r($cups);
    $star1 = $cups[1]['n'];
    $star2 = $cups[$star1]['n'];
    echo "$star1 * $star2 = " . $star1 * $star2 . "\n";
  }
}


