<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2021;

use App\Console\AdventBase;

class Day8Part1 extends AdventBase {

  protected $signature = "year2021:day8part1";
  protected $description = "Advent Of Code 2021 Day 8 Part 1";


  public function handle() {

    $lines = $this->_readInput();
    $count = 0;
    foreach($lines as $line) {
      list($inputs, $outputs) = explode(' | ', $line);
      $inputs = explode(' ', $inputs);
      $outputs = explode(' ', $outputs);
      foreach($outputs as $output) {
        // echo "$output\n";
        if (in_array(strlen($output), [2, 3, 4, 7])) {
          $count++;
        }
      }
    }
    echo "count: $count\n";
    exit;

    $digitMasks = array(
      0 => str_split("abc.efg"),
      1 => str_split("..c..f."),
      2 => str_split("a.cde.g"),
      3 => str_split("a.cd.fg"),
      4 => str_split(".bcd.f."),
      5 => str_split("ab.d.fg"),
      6 => str_split("ab.defg"),
      7 => str_split("a.c..f."),
      8 => str_split("abcdefg"),
      9 => str_split("abcd.fg"),
    );
    $digitSegments = array(
      0 => str_split("abcefg"),
      1 => str_split("cf"),
      2 => str_split("acdeg"),
      3 => str_split("acdfg"),
      4 => str_split("bcdf"),
      5 => str_split("abdfg"),
      6 => str_split("abdefg"),
      7 => str_split("acf"),
      8 => str_split("abcdefg"),
      9 => str_split("abcdfg"),
    );
    echo print_r($digitSegments, true) . "\n";

    $digitsBySegmentCount = [];
    foreach($digitSegments as $digit => $segments) {
      $segmentCount = count($segments);
      if (!isset($digitsBySegmentCount[$segmentCount])) {
        $digitsBySegmentCount[$segmentCount] = [];
      }
      $digitsBySegmentCount[$segmentCount][] = $digit;
    }
    ksort($digitsBySegmentCount);
    echo print_r($digitsBySegmentCount, true) . "\n";
  }
}
