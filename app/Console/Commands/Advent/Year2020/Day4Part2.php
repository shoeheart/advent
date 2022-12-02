<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day4Part2 extends AdventBase {

  protected $signature = "year2020:day4part2";
  protected $description = "Advent Of Code 2020 Day 4 Part 2";

  public function handle() {
    $required = [
      'byr' => function($value) {
        return
          !empty($value)
          &&
          strlen($value) == 4
          &&
          is_numeric($value)
          &&
          intval($value) >= 1920
          &&
          intval($value) <= 2002
        ;
      },
      'iyr' => function($value) {
        return
          !empty($value)
          &&
          strlen($value) == 4
          &&
          is_numeric($value)
          &&
          intval($value) >= 2010
          &&
          intval($value) <= 2020
        ;
      },
      'eyr' => function($value) {
        return
          !empty($value)
          &&
          strlen($value) == 4
          &&
          is_numeric($value)
          &&
          intval($value) >= 2020
          &&
          intval($value) <= 2030
        ;
      },
      'hgt' => function($value) {
        //echo "height: " . $value . "\n";
        preg_match('/(\d+)(in|cm)/', $value, $matches);
        //echo "matches: " . print_r($matches, true) . "\n";
        return
          !empty($matches)
          &&
          count($matches) == 3
          &&
          is_numeric($matches[1])
          &&
          (
            (
              $matches[2] == "cm"
              &&
              intval($matches[1]) >= 150
              &&
              intval($matches[1]) <= 193
            )
            ||
            (
              $matches[2] == "in"
              &&
              intval($matches[1]) >= 59
              &&
              intval($matches[1]) <= 76
            )
          )
        ;
      },
      'hcl' => function($value) {
        //echo "hcl: " . $value . "\n";
        preg_match('/#([0-9a-f]{6})$/', $value, $matches);
        //echo "matches: " . print_r($matches, true) . "\n";
        return
          !empty($matches)
          &&
          count($matches) == 2
        ;
      },
      'ecl' => function($value) {
        //echo "ecl: " . $value . "\n";
        preg_match('/^(amb|blu|brn|gry|grn|hzl|oth)$/', $value, $matches);
        //echo "matches: " . print_r($matches, true) . "\n";
        return
          !empty($matches)
          &&
          count($matches) == 2
        ;
      },
      'pid' => function($value) {
        //echo "pid: " . $value . "\n";
        preg_match('/^(\d{9})$/', $value, $matches);
        //echo "matches: " . print_r($matches, true) . "\n";
        return
          !empty($matches)
          &&
          count($matches) == 2
        ;
      },
      'cid' => function($value) { return true; },
    ];

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
        //
        // validate data
        if (call_user_func($required[$field], $value)) {
          //echo "valid: " . $attribute . "\n";
          if (isset($found[$field])) {
            $found[$field]++;
          } else {
            $found[$field] = 1;
          }
        }
      }
      if (count($found) == count($required)) $valid++;
    }

    echo "valid: " . $valid . "\n";
  }
}
