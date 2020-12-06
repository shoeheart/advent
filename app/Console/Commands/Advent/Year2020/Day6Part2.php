<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\Commands\Advent\AdventBase;

class Day6Part2 extends AdventBase {

  protected $signature = "year2020:day6part2";
  protected $description = "Advent Of Code 2020 Day 6 Part 2";

  public function handle() {
    $groups = $this->_readGroupedInput();
    //print_r($groups);
    //echo "\n";

    $sum = 0;
    foreach ($groups as $group) {
      //print_r($group);
      //echo "\n";
      $yesses = [];
      foreach($group as $person) {
        //print_r($person);
        //echo "\n";
        foreach(str_split($person) as $answer) {
          if (isset($yesses[$answer])) {
            $yesses[$answer]++;
          } else {
            $yesses[$answer] = 1;
          }
        }
      }
      $unanimous = 0;
      foreach($yesses as $question => $numberOfPeopleAnsweringYes) {
        if ($numberOfPeopleAnsweringYes == count($group)) {
          $unanimous++;
        }
      }
      //print_r($yesses);
      //echo "\n";
      //print_r($unanimous);
      //echo "\n";
      $sum += $unanimous;
    }
    echo "sum: " . $sum . "\n";
  }
}
