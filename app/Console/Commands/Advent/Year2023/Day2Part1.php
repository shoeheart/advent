<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2023;

// use Illuminate\Console\Command;
use App\Console\AdventBase;

class Day2Part1 extends AdventBase
{
  protected $signature = 'year2023:day2part1';
  protected $description = 'Advent of Code 2023 Day 2 Part 1';

  public function handle() {
    $lines = $this->_readInput();

    $possibleGames = [];
    foreach ($lines as $line) {
      # Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green
      list($game, $draws) = explode(':', trim($line));
      list(, $game) = explode(' ', trim($game));
      echo "Game $game" . "\n";
      # echo $draws . "\n";
      $draws = explode(';', trim($draws));
      $possible = true;
      foreach ($draws as $draw) {
        # echo $draw . "\n";
        $colorDraws = explode(',', trim($draw));
        foreach ($colorDraws as $colorDraw) {
          echo $colorDraw . "\n";
          list($count, $color) = explode(' ', trim($colorDraw));
          # echo $color . "\n";
          # echo $count . "\n";
          if (
            ($color == "red" && $count > 12) ||
            ($color == "green" && $count > 13) ||
            ($color == "blue" && $count > 14)
          ) {
            echo "impossible due to $color $count\n";
            $possible = false;
            break;
          } else {
            echo "possible due to $color $count\n";
          }
        }
        if (! $possible) break;
      }
      if ($possible) $possibleGames[] = $game;
    }
    print_r($possibleGames);
    echo array_sum($possibleGames) . "\n";

    return parent::SUCCESS;
  }
}
