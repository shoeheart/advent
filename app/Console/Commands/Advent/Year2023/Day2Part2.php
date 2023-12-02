<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2023;

// use Illuminate\Console\Command;
use App\Console\AdventBase;

class Day2Part2 extends AdventBase
{
  protected $signature = 'year2023:day2part2';
  protected $description = 'Advent of Code 2023 Day 2 Part 2';

  public function handle() {
    $lines = $this->_readInput();

    $gameCubes = [];
    foreach ($lines as $line) {
      # Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green
      list($game, $draws) = explode(':', trim($line));
      list(, $game) = explode(' ', trim($game));
      echo "Game $game" . "\n";
      # echo $draws . "\n";
      $draws = explode(';', trim($draws));
      $possible = true;
      $redMin = 0;
      $greenMin = 0;
      $blueMin = 0;
      foreach ($draws as $draw) {
        # echo $draw . "\n";
        $colorDraws = explode(',', trim($draw));
        foreach ($colorDraws as $colorDraw) {
          echo $colorDraw . "\n";
          list($count, $color) = explode(' ', trim($colorDraw));
          # echo $color . "\n";
          # echo $count . "\n";
          if ($color == "red") $redMin = max($redMin, $count);
          if ($color == "green") $greenMin = max($greenMin, $count);
          if ($color == "blue") $blueMin = max($blueMin, $count);
        }
      }
      $gameCubes[] = $redMin * $greenMin * $blueMin;
    }
    echo array_sum($gameCubes) . "\n";

    return parent::SUCCESS;
  }
}
