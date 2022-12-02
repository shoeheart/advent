<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2021;

use App\Console\AdventBase;

class Day14Part2 extends AdventBase {

  protected $signature = "year2021:day14part2";
  protected $description = "Advent Of Code 2021 Day 14 Part 2";


  public function handle() {

    $lines = $this->_readInput();
    $count = 0;
	$template = $lines[0];
	$insertions = array();
    for ($i = 2; $i < count($lines); $i++) {
		list($match, $insert) = explode(' -> ', $lines[$i]);
		$insertions[$match] = $insert;
	}
	echo "$template\n";
    echo print_r($insertions, true) . "\n";

	$firstElement = $template[0];
	$lastElement = $template[strlen($template) - 1];
	$pairs = array();
	for ($i = 0; $i < strlen($template) - 1; $i++) {
		$pair = $template[$i] . $template[$i + 1];
		if (empty($pairs[$pair])) {
			$pairs[$pair] = 0;
		}
		$pairs[$pair]++;
	}
	echo "start:\n";
    echo print_r($pairs, true) . "\n";
	// exit;

	for ($t = 0; $t < 40; $t++) {
		$newPairs = array();
		foreach($pairs as $pair => $pairCount) {
			if (empty($insertions[$pair])) {
				echo "$pair not found!!!\n";
				exit;
				$newPairs[$pair] = $pairCount;
			} else {
				$leftPair = $pair[0] . $insertions[$pair];
				$rightPair = $insertions[$pair] . $pair[1];
				if (empty($newPairs[$leftPair])) {
					$newPairs[$leftPair] = $pairCount;
				} else {
					$newPairs[$leftPair] += $pairCount;
				}
				if (empty($newPairs[$rightPair])) {
					$newPairs[$rightPair] = $pairCount;
				} else {
					$newPairs[$rightPair] += $pairCount;
				}
			}
		}
		$pairs = $newPairs;
		// echo "after $t:\n";
    	// echo print_r($pairs, true) . "\n";
	}

	$counts = array();
	foreach($pairs as $pair => $pairCount) {
		if (empty($counts[$pair[0]])) {
			$counts[$pair[0]] = 0;
		}
		$counts[$pair[0]] += $pairCount;
		if (empty($counts[$pair[1]])) {
			$counts[$pair[1]] = 0;
		}
		$counts[$pair[1]] += $pairCount;
	}

	// add in first and last elements before taking half
	// since those are the only two that didn't get double counted
	$counts[$firstElement]++;
	$counts[$lastElement]++;

	asort($counts);
    echo print_r($counts, true) . "\n";

	sort($counts);
    echo print_r($counts, true) . "\n";

	echo (($counts[(count($counts) - 1)] / 2 ) - ($counts[0] / 2)) . " diff \n";

	//echo "$template\n";
  }
}
