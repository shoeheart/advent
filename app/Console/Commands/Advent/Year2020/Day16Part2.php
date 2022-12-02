<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day16Part2 extends AdventBase {

  protected $signature = "year2020:day16part2";
  protected $description = "Advent Of Code 2020 Day 16 Part 2";

  public function handle() {
    $lines = $this->_readInput();
    $fields = [];
    $yourTicket;
    $nearbyTickets = [];
    $i = 0;
    $scanning = 'fields';
    foreach ($lines as $line) {
      if ($scanning == 'fields') {
        if (empty($line)) {
          $scanning = 'your ticket:';
        } else {
          preg_match(
            '/(.+): (\d+)-(\d+) or (\d+)-(\d+)$/',
            $line,
            $matches
          );
          // print_r($matches);
          // echo "\n";
          $fields[$matches[1]][] = $matches[2];
          $fields[$matches[1]][] = $matches[3];
          $fields[$matches[1]][] = $matches[4];
          $fields[$matches[1]][] = $matches[5];
        }
      } elseif ($scanning == 'your ticket:') {
        $scanning = 'your ticket value';
      } elseif ($scanning == 'your ticket value') {
        $yourTicket = explode(',', $line);
        $scanning = 'blank before nearby tickets';
      } elseif ($scanning == 'blank before nearby tickets') {
        $scanning = 'nearby tickets:';
      } elseif ($scanning == 'nearby tickets:') {
        $scanning = 'nearby tickets value';
      } elseif ($scanning == 'nearby tickets value') {
        $nearbyTickets[] = explode(',', $line);
      } else {
        "bad scanning $scanning on line $i: $line\n";
      }
    }
    //print_r($fields);
    //echo "\n";
    //print_r($yourTicket);
    //echo "\n";
    //print_r($nearbyTickets);
    //echo "\n";

    $invalidValueSum = 0;
    $validNearbyTickets = [];
    foreach($nearbyTickets as $nearbyTicket) {
      $ticketValid = true;
      foreach($nearbyTicket as $value) {
        $valueValid = false;
        foreach($fields as $field) {
          if (
            (
              $value >= $field[0] &&
              $value <= $field[1]
            )
            ||
            (
              $value >= $field[2] &&
              $value <= $field[3]
            )
          ) {
            $valueValid = true;
            break;
          }
        }
        if ($valueValid) {
          // found field for which it's valid so move
          // to next value in ticket
          continue;
        } else {
          $invalidValueSum += $value;
          $ticketValid = false;
        }
      }
      if ($ticketValid) {
        $validNearbyTickets[] = $nearbyTicket;
      }
    }
    echo "invalidValueSum: $invalidValueSum\n";
    echo "total nearby tickets: " . count($nearbyTickets) . "\n";
    echo "valid nearby tickets: " . count($validNearbyTickets) . "\n";

    $possibleFieldsForPosition = [];

    $possibleFieldsForPosition = [];
    foreach(array_keys($fields) as $key) {
      for ($i = 0; $i < count($fields); $i++) {
        $possibleFieldsForPosition[$i][$key] = true;
      }
    }
    //print_r($possibleFieldsForPosition);
    //echo "\n";

    // unset fields from positions that can't be valid
    for ($i = 0; $i < count($fields); $i++) {
      foreach ($fields as $field => $validValues) {
        foreach ($validNearbyTickets as $ticket) {
          $value = $ticket[$i];
          if (
            $value < $validValues[0]
            ||
            (
              $value > $validValues[1] &&
              $value < $validValues[2]
            )
            ||
            $value > $validValues[3]
          ) {
            unset($possibleFieldsForPosition[$i][$field]);
          }
        }
      }
    }
    //print_r($possibleFieldsForPosition);
    //echo "\n";

    // find positions that have only one possible field
    // that's valid, and remove that field from other positions.
    $solos = [];
    while (count($solos) < count($fields)) {
      foreach ($possibleFieldsForPosition as $position => $possible) {
        //echo "position: $position\n";
        //print_r($possible);
        //echo "\n";
        if (count($possible) == 1) {
          $solo = array_keys($possible)[0];
          if (! isset($solos[$solo])) {
            echo "solo: $position: $solo\n";
            $solos[$solo] = true;
            foreach ($possibleFieldsForPosition as $inner => $prunePossible) {
              if ($inner != $position) {
                unset($possibleFieldsForPosition[$inner][$solo]);
              }
            }
          }
        }
      }
    }
    print_r($possibleFieldsForPosition);
    echo "\n";

    $product = 1;
    foreach ($possibleFieldsForPosition as $position => $possible) {
      if (substr(array_keys($possible)[0], 0, 9) == 'departure') {
        $product = $product * $yourTicket[$position];
        echo "product: $product\n";
      }
    }
  }
}
