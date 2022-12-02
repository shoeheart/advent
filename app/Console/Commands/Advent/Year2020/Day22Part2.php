<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day22Part2 extends AdventBase {

  protected $signature = "year2020:day22part2";
  protected $description = "Advent Of Code 2020 Day 22 Part 2";

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

    list($winner, $score) = $this->_play($player1, $player2);
    echo "player $winner wins with score $score\n";
  }

  protected function _play($player1, $player2) {
    $previous1 = [];
    $previous2 = [];

    while(count($player1) > 0 && count($player2) > 0) {

      if (in_array($player1, $previous1) && in_array($player2, $previous2)) {
        echo "seen before!!!\n";
        return array(1, $this->_score($player1));
      }
      $previous1[] = $player1;
      $previous2[] = $player2;

      $p1 = array_shift($player1);
      $p2 = array_shift($player2);

      if ($p1 <= count($player1) && $p2 <= count($player2)) {
        echo "recursive game\n";
        $recursive1 = array_slice($player1, 0, $p1);
        $recursive2 = array_slice($player2, 0, $p2);
        echo "  p1: " . implode(',', $recursive1) . "\n";
        echo "  vs:\n";
        echo "  p2: " . implode(',', $recursive2) . "\n";
        list($subwinner, $_) = $this->_play($recursive1, $recursive2);
        if ($subwinner == 1) {
          echo "p1 wins\n";
          $player1[] = $p1;
          $player1[] = $p2;
        } else {
          echo "p2 wins\n";
          $player2[] = $p2;
          $player2[] = $p1;
        }
        echo "p1: " . implode(',', $player1) . "\n";
        echo "p2: " . implode(',', $player2) . "\n";
      } else {
        echo "plain game $p1 vs $p2\n";
        if ($p1 > $p2) {
          echo "p1 wins\n";
          $player1[] = $p1;
          $player1[] = $p2;
        } else {
          echo "p2 wins\n";
          $player2[] = $p2;
          $player2[] = $p1;
        }
        echo "p1: " . implode(',', $player1) . "\n";
        echo "p2: " . implode(',', $player2) . "\n";
      }
    }
    echo "p1: " . implode(',', $player1) . "\n";
    echo "p2: " . implode(',', $player2) . "\n";
    if (count($player1) > 0) {
      return array(1, $this->_score($player1));
    } else {
      return array(2, $this->_score($player2));
    }
    // print_r($player1);
    // print_r($player2);
  }
}
