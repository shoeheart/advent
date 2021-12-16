<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2021;

use App\Console\Commands\Advent\AdventBase;

class Day14Part1 extends AdventBase {

  protected $signature = "year2021:day14part1";
  protected $description = "Advent Of Code 2021 Day 14 Part 1";


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

	for ($t = 0; $t < 10; $t++) {
		$newTemplate = "";
		for ($i = 0; $i < strlen($template) - 1; $i++) {
			$pair = substr($template, $i, 2);
			// echo "checking $pair\n";
			if (!empty($insertions[$pair])) {
				$newTemplate .= ($pair[0] . $insertions[$pair]);
			} else {
				echo "$pair not found!!!\n";
				exit;
				$newTemplate .= $pair[0];
			}
		}
		$newTemplate .= $template[strlen($template) - 1];
		$template = $newTemplate;
		// echo "$template\n";
	}
	// exit;
	$counts = [];
	for ($i = 0; $i < strlen($template); $i++) {
		if (empty($counts[$template[$i]])) {
			$counts[$template[$i]] = 0;
		}
		$counts[$template[$i]]++;
	}
	asort($counts);
    echo print_r($counts, true) . "\n";
	sort($counts);
    echo print_r($counts, true) . "\n";

	echo ($counts[(count($counts) - 1)] - $counts[0]) . " diff \n";

	//echo "$template\n";
  }
}