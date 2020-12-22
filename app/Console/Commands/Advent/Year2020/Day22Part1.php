<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\Commands\Advent\AdventBase;

class Day22Part1 extends AdventBase {

  protected $signature = "year2020:day22part1";
  protected $description = "Advent Of Code 2020 Day 22 Part 1";

  protected function _score($deck) {
    $deck = array_reverse($deck);
    $count = count($deck);
    $sum = 0;
    for($i = 0; $i < $count; $i++) {
      $sum += ($i + 1) * array_shift($deck);
    }
    return $sum;
  }

  public function handle() {
    $lines = $this->_readInput();
    $player = 0;
    $cards[1] = [];
    $cards[2] = [];
    foreach($lines as $line) {
      if (preg_match('/Player \d:/', $line, $matches)) {
        $player++;
      } else {
        $cards[$player][] = intval($line);
      }
    }
    $player1 = array_slice($cards[1], 0, count($cards[2]));
    $player2 = $cards[2];
    // print_r($player1);
    // print_r($player2);

    while(count($player1) > 0 && count($player2) > 0) {
      $p1 = array_shift($player1);
      $p2 = array_shift($player2);
      // echo "$p1 vs $p2\n";
      if ($p1 > $p2) {
        // echo "p1 wins\n";
        $player1[] = $p1;
        $player1[] = $p2;
      } else {
        // echo "p2 wins\n";
        $player2[] = $p2;
        $player2[] = $p1;
      }
      // echo "p1: " . implode(',', $player1) . "\n";
      // echo "p2: " . implode(',', $player2) . "\n";
    }
    echo "p1: " . implode(',', $player1) . "\n";
    echo "p2: " . implode(',', $player2) . "\n";
    if (count($player1) > 0) {
      echo "player1 won with score: " . $this->_score($player1) . "\n";
    } else {
      echo "player2 won with score: " . $this->_score($player2) . "\n";
    }
    // print_r($player1);
    // print_r($player2);

  }
}
