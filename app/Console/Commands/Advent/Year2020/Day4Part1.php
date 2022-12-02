<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day4Part1 extends AdventBase {

  protected $signature = "year2020:day4part1";
  protected $description = "Advent Of Code 2020 Day 4 Part 1";
  protected $_required = [
    'byr',
    'iyr',
    'eyr',
    'hgt',
    'hcl',
    'ecl',
    'pid',
    'cid',
  ];

  public function handle() {
    $passportLines = $this->_readInput();

    $passports = [];
    $currentPassport = "";
    foreach ($passportLines as $passportLine) {
      if (empty($passportLine)) {
        $passports[] = trim($currentPassport);
        $currentPassport = "";
      } else {
        $currentPassport .= " " . $passportLine;
      }
    }
    $passports[] = trim($currentPassport);

    //print_r($passports);

    $valid = 0;
    foreach($passports as $passport) {
      $found = [];
      $found['cid'] = 0;
      $attributes = explode(" ", $passport);
      // print_r($attributes);
      foreach($attributes as $attribute) {
        // print_r($attribute);
        // print_r(explode(':', $attribute));
        list($field, $value) = explode(':', $attribute);
        if (isset($found[$field])) {
          $found[$field]++;
        } else {
          $found[$field] = 0;
        }
      }
      if (count($found) == count($this->_required)) $valid++;
    }

    echo "valid: " . $valid . "\n";
  }
}
