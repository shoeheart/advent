<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\Commands\Advent\AdventBase;

class Day16Part1 extends AdventBase {

  protected $signature = "year2020:day16part1";
  protected $description = "Advent Of Code 2020 Day 16 Part 1";

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
    print_r($fields);
    echo "\n";
    print_r($yourTicket);
    echo "\n";
    print_r($nearbyTickets);
    echo "\n";

    $invalidValueSum = 0;
    foreach($nearbyTickets as $nearbyTicket) {
      foreach($nearbyTicket as $value) {
        $valid = false;
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
            $valid = true;
            break;
          }
        }
        if ($valid) {
          // found field for which it's valid so move
          // to next value in ticket
          continue;
        } else {
          $invalidValueSum += $value;
        }
      }
    }
    echo "invalidValueSum: $invalidValueSum\n";
  }
}