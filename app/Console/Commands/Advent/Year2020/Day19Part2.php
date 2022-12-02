<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day19Part2 extends AdventBase {

  protected $signature = "year2020:day19part2";
  protected $description = "Advent Of Code 2020 Day 19 Part 2";
  protected $stringRules = [];
  protected $finiteCompositeRules = [];
  protected $recursiveRules = [];
  protected $images = [];


  // after collapsing rules, we are left with
  // 0: 8 11
  // 8: 42 | 42 8
  // 11: 42 31 | 42 11 31
  //
  // result is however may 31s appear at end, must equal or great
  //
  // so for a message to match, it must start with one or more 42s
  // followed by again one or more 42s, and finally a single 31
  //
  // AND however many 31s appear at end, must greater number of
  // 42s at beginning in order to match.
  //

  protected function _cartesian($a1, $a2) {
    //echo "carting\n";
    //print_r($a1);
    //print_r($a2);
    if (empty($a1)) {
      return $a2;
    }
    //echo "a1 not empty\n";
    $result = [];
    foreach ($a1 as $a1v) {
      foreach($a2 as $a2v) {
        //echo "combining $a1v and $a2v\n";
        $result[] = $a1v . $a2v;
        //print_r($result);
      }
    }
    return $result;
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
        // skip recursive rules.  handled in code
        if ($ruleNumber == 0 || $ruleNumber == 8 || $ruleNumber == 11) {
          continue;
        }
        if (strpos($ruleDefinition, '"') === false) {
          $subrules = explode('|', trim($ruleDefinition));
          $rule = array();

          foreach($subrules as $subrule) {
            $subruleset = [];
            $tokens = explode(' ', trim($subrule));
            foreach($tokens as $token) {
              $subruleset[] = $token;
            }
            $rule[] = $subruleset;
          }
          $this->finiteCompositeRules[$ruleNumber] = $rule;
        } else {
          // only single character rules in input so grab the char
          // but keep it as array of possible values since we
          // need each finiteCompositeRule to decompose down to
          // an array of possible string matches
          $this->stringRules[$ruleNumber] = array($ruleDefinition[1]);
        }
      } else {
        $this->images[] = $line;
      }
    }
    // 0: 8 11
    // 8: 42 | 42 8'
    // 11: 42 31 | 42 11 31'
    $this->recursiveRules[0] = array(array(8, 11));
    $this->recursiveRules[8] = array(array(42), array(42, 8));
    $this->recursiveRules[11] = array(array(42, 31), array(42, 11, 31));

    // echo "string rules:\n";
    // print_r($this->stringRules);
    // echo "finite composite rules:\n";
    // print_r($this->finiteCompositeRules);
    // echo "recursive rules:\n";
    // print_r($this->recursiveRules);

    while (count($this->finiteCompositeRules)) {
      foreach($this->finiteCompositeRules as $ruleNumber => $subrulesets) {
        $stringRule = [];
        //echo "checking $ruleNumber\n";
        $allStrings = true;
        foreach($subrulesets as $i => $subruleset) {
          $subStringRule = [];
          if (! $allStrings) {
            //echo "breaking subrulesets\n";
            break;
          }
          foreach($subruleset as $j => $subrule) {
            //echo "checking sub $subrule\n";
            if (! isset($this->stringRules[$subrule])) {
              //echo "breaking subrule\n";
              $allStrings = false;
              break;
            } else {
              //echo "carting $ruleNumber $subrule\n";
              //print_r($subStringRule);
              //print_r($this->stringRules[$subrule]);
              $subStringRule =
                $this->_cartesian(
                  $subStringRule,
                  $this->stringRules[$subrule]
                );
              //echo "subStringRule\n";
              //print_r($subStringRule);
            }
          }
          $stringRule = array_merge($stringRule, $subStringRule);
        }
        if ($allStrings) {
          //echo "rule $ruleNumber is composed of all strings\n";
          //print_r($stringRule);
          //echo "\n";
          $this->stringRules[$ruleNumber] = $stringRule;
          unset($this->finiteCompositeRules[$ruleNumber]);
        }
      }
    }

    //echo "all string rules:\n";
    //print_r($this->stringRules);

    $usedStringRules = [];
    foreach ($this->recursiveRules as $ruleNumber => $subrulesets) {
      foreach ($subrulesets as $subrules) {
        foreach ($subrules as $subrule) {
          $usedStringRules[] = $subrule;
        }
      }
    }

    foreach ($this->stringRules as $ruleNumber => $_) {
      if (! (in_array($ruleNumber, $usedStringRules))) {
        unset($this->stringRules[$ruleNumber]);
      }
    }

    // echo "Using rules:\n";
    // echo "recursive rules:\n";
    // print_r($this->recursiveRules);
    // //echo "finite composite rules:\n";
    // //print_r($this->finiteCompositeRules);
    // echo "string rules:\n";
    // print_r($this->stringRules);

    // echo "31 initial count: " . count($this->stringRules[31]) . "\n";
    $this->stringRules[31] = array_unique($this->stringRules[31]);
    //echo "31 unique count: " . count($this->stringRules[31]) . "\n";
    sort($this->stringRules[31]);
    //echo "31 sorted count: " . count($this->stringRules[31]) . "\n";

    //echo "42 initial count: " . count($this->stringRules[42]) . "\n";
    $this->stringRules[42] = array_unique($this->stringRules[42]);
    //echo "42 unique count: " . count($this->stringRules[42]) . "\n";
    sort($this->stringRules[42]);
    //echo "42 sorted count: " . count($this->stringRules[42]) . "\n";

    // echo "overlap between 31 and 42\n";
    // print_r(
    //   array_intersect(
    //     $this->stringRules[31],
    //     $this->stringRules[42]
    //   )
    // );

    echo "string rules:\n";
    print_r($this->stringRules);

    // exit -1;

    // problem here is we need to consume all the 31s at end of string
    // before starting to look for 42s and count them
    // so we can match at least one more 42 in remainder
    // than we found 31s at end
    $endInThirtyOne = [];
    foreach($this->images as $image) {
      list($remainder, $thirtyOnesFound) = $this->_consumeThirtyOnes($image, 0);
      if ($thirtyOnesFound > 0) {
        $endInThirtyOne[] = array($remainder, $thirtyOnesFound);
      } else {
        "no 31s found at end of $image\n";
      }
    }

    //echo "out of " . count($endInThirtyOne) . " candidates to match 42+: " . count($endInThirtyOne) . "\n";
    //print_r($endInThirtyOne);

    $startWithFortyTwoPlusOneNoRemainder = [];
    foreach($endInThirtyOne as $imageAndThirtyOneCount) {
      $toMatch = $imageAndThirtyOneCount[0];
      $needed = $imageAndThirtyOneCount[1] + 1;
      $found = $this->_matchFortyTwoPlusOneNoRemainder($toMatch);
      //echo "found $found vs needed $needed\n";
      if ($found >= $needed) {
        $startWithFortyTwoPlusOneNoRemainder[] = $imageAndThirtyOneCount[0];
      } else {
        echo "NOT ENOUGH 42 MATCH: " . $imageAndThirtyOneCount[0] . "\n";
      }
    }

    echo "final match count: " . count($startWithFortyTwoPlusOneNoRemainder) . "\n";
  }

  protected function _consumeThirtyOnes($image, $thirtyOnesFound = 0) {
    foreach($this->stringRules[31] as $thirtyOne) {
      $expression = '/^(.*)(' . $thirtyOne . ')$/';
      //echo "$expression\n";
      if (preg_match($expression, $image, $matches)) {
        //echo "$image ends in 31\n";
        //echo "matched " . $matches[2] . "\n";
        //echo "remainder " . $matches[1] . "\n";
        return $this->_consumeThirtyOnes($matches[1], $thirtyOnesFound + 1);
      }
    }
    //echo "returning unchanged ($image, $thirtyOnesFound)\n";
    return array($image, $thirtyOnesFound);
  }

  protected function _matchFortyTwoPlusOneNoRemainder($image, $foundWithNoRemainder = 0) {

    //echo "_matchFortyTwoPlusOneNoRemainder: $image\n";
    if (strlen($image) == 0) {
      //echo "ran out in good way!\n";
      return $foundWithNoRemainder;
    }
    foreach($this->stringRules[42] as $fortyTwo) {
      $expression = '/^(' . $fortyTwo . ')(.*)$/';
      //echo "testing for 42: $image\n";
      //echo "$expression\n";
      if (preg_match($expression, $image, $matches)) {
        //echo "matched " . $matches[1] . "\n";
        //echo "remainder " . $matches[2] . "\n";
        //print_r($matches);
        // if match resulted in remainder of length zero
        // or if remainder also matches 42, we match
        // and we can stop searching other forks
        return $this->_matchFortyTwoPlusOneNoRemainder($matches[2], $foundWithNoRemainder + 1);
      }
    }
    //echo "no 42s matched remainder $image\n";
    return 0;
  }
}
