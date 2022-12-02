<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day19Part1 extends AdventBase {

  protected $signature = "year2020:day19part1";
  protected $description = "Advent Of Code 2020 Day 19 Part 1";
  protected $rules = [];
  protected $images = [];

  protected function _match($ruleNumber, $image) {
    $rule = $this->rules[$ruleNumber];
    echo "############ match\n";
    print_r($rule);
    print_r($image);
    echo "\n";
    if ($rule['type'] == 'character') {
      if ($image[0] == $rule['value']) {
        return array(true, substr($image, 1));
      } else {
        return array(false, $image);
      }
    } else {
      // composite rule
      $valid = false;
      foreach ($rule['subrulesets'] as $subruleset) {
        $remainder = $image;
        foreach ($subruleset as $subrule) {
          list($valid, $remainder) = $this->_match($subrule, $remainder);
          if (!$valid) break;
        }
        // all subrules matched
        if ($valid) {
          return array(true, $remainder);
        }
      }
    }
  }

  public function handle() {
    $lines = $this->_readInput();
    $mode = 'rules';
    foreach($lines as $line) {
      if (empty($line)) {
        $mode = 'images';
        continue;
      }
      if ($mode == 'rules') {
        $split = explode(':', $line);
        $ruleNumber = $split[0];
        $ruleDefinition = trim($split[1]);
        if (strpos($ruleDefinition, '"') === false) {
          $subrules = explode('|', trim($ruleDefinition));
          $rule = array('type' => 'composite', 'subrulesets' => []);

          foreach($subrules as $subrule) {
            $subruleset = [];
            $tokens = explode(' ', trim($subrule));
            foreach($tokens as $token) {
              $subruleset[] = $token;
            }
            $rule['subrulesets'][] = $subruleset;
          }
          $this->rules[$ruleNumber] = $rule;
        } else {
          $subrules = explode('|', $ruleDefinition);
          $this->rules[$ruleNumber] = array('type' => 'character', 'value' => $ruleDefinition[1]);
        }
      } else {
        $this->images[] = $line;
      }
    }
    // print_r($this->rules);
    // echo "\n";
    // print_r($this->images);
    // echo "\n";

    $matches = [];
    foreach($this->images as $image) {
      list($valid, $remainder) = $this->_match(0, $image);
      if ($valid && strlen($remainder) == 0) {
        $matches[] = $image;
      }
    }
    print_r($matches);
    echo "matches: " . count($matches);
  }
}
