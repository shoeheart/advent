<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\AdventBase;

class Day21Part1 extends AdventBase {

  protected $signature = "year2020:day21part1";
  protected $description = "Advent Of Code 2020 Day 21 Part 1";

  public function handle() {
    $lines = $this->_readInput();
    foreach($lines as $line) {
      preg_match('/(.*)\(contains (.*)\)/', $line, $matches);
      //print_r($matches);
      // $ingredients = explode(' ', trim($matches[1]));
      $allFoods[] = $ingredients = trim($matches[1]);
      $contains = explode(', ', trim($matches[2]));
      // print_r($ingredients);
      // print_r($contains);
      foreach ($contains as $contain) {
        if (! isset($analytes[$contain])) {
          $analytes[$contain] = [];
        }
        $analytes[$contain][] = $ingredients;
      }
    }
    print_r($allFoods);
    echo "\n";
    print_r($analytes);
    echo "\n";

    $allergens = [];
    $ambiguousCount = 999;
    while ($ambiguousCount > 0) {
      list($allergens, $ambiguousCount) = $this->identify($analytes, $allergens);
      // echo "got back:\n";
      // print_r($allergens);
      // echo "\n";
      // print_r($ambiguousCount);
      // echo "\n";
    }

    // Determine which ingredients cannot possibly contain any of the allergens in your list.
    // How many times do any of those ingredients appear?
    $sum = $this->countUnused($allFoods, array_keys($allergens));

    print_r($allergens);
    echo "\n";

    echo "unused count $sum\n";
  }

  protected function identify($analytes, $allergens) {
    $ambiguous = [];
    foreach($analytes as $allergen => $foods) {
      if (in_array($allergen, $allergens)) {
        //echo "skipping already found $allergen\n";
        continue;
      }
      $ingredients = NULL;
      foreach($foods as $food) {
        $allIngredients = explode(' ', $food);
        // ignore ingredients already identified as containing an allergen
        $unidentifiedIngredients = array_diff($allIngredients, array_keys($allergens));
        if (!isset($ingredients)) {
          $ingredients = $unidentifiedIngredients;
        } else {
          $ingredients = array_intersect($ingredients, $unidentifiedIngredients);
        }
      }
      //echo "allergen: $allergen\n";
      //print_r($ingredients);
      //echo "\n";
      if (count($ingredients) == 0) {
        echo "$allergen empty\n";
        exit -1;
      } elseif (count($ingredients) == 1) {
        //echo "$allergen found!!!\n";
        $allergens[array_shift($ingredients)] = $allergen;
      } else {
        //echo "$allergen still ambiguous\n";
        $ambiguous[$allergen] = $ingredients;
      }
    }

    // echo "returning\n";
    // print_r($allergens);
    // print_r($ambiguous);
    // print_r(array($allergens, count($ambiguous)));
    // echo "\n";
    return array($allergens, count($ambiguous));
  }

  protected function countUnused($allFoods, $usedIngredients) {
    $sum = 0;
    foreach($allFoods as $food) {
      echo "counting $food\n";
      $allIngredients = explode(' ', $food);
      echo "total ingredients: " . count($allIngredients) . "\n";
      // ignore ingredients already identified as containing an allergen
      echo "total ingredients: " . print_r($allIngredients, true) . "\n";
      $remainingIngredients = array_diff($allIngredients, $usedIngredients);
      echo "remaining ingredients: " . count($remainingIngredients) . "\n";
      echo "remaining ingredients: " . print_r($remainingIngredients, true) . "\n";
      $sum += count($remainingIngredients);
    }
    return $sum;
  }
}
