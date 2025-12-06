<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2025;

use App\Console\AdventBase;

class Day6Part1 extends AdventBase
{
  protected $signature = 'year2025:day6part1';
  protected $description = 'Advent of Code 2025 Day 6 Part 1';

  public function handle() {
    $lines = $this->_readInput();

    // Parse the worksheet into columns (each char position across all lines)
    $maxLen = max(array_map('strlen', $lines));
    $columns = [];

    for ($col = 0; $col < $maxLen; $col++) {
      $columnData = [];
      foreach ($lines as $line) {
        $char = $col < strlen($line) ? $line[$col] : ' ';
        $columnData[] = $char;
      }
      $columns[$col] = $columnData;
    }

    // Extract problems from columns
    $problems = $this->extractProblems($columns);

    // Calculate each problem's answer
    $grandTotal = 0;
    foreach ($problems as $idx => $problem) {
      $answer = $this->calculateProblem($problem);
      $grandTotal += $answer;
    }

    echo "Grand total: $grandTotal\n";

    return parent::SUCCESS;
  }

  private function extractProblems(array $columns): array {
    $problems = [];
    $currentProblem = [];

    foreach ($columns as $columnData) {
      // Check if this is an empty column (all spaces)
      $isEmpty = true;
      foreach ($columnData as $char) {
        if ($char !== ' ') {
          $isEmpty = false;
          break;
        }
      }

      if ($isEmpty) {
        if (!empty($currentProblem)) {
          $problems[] = $currentProblem;
          $currentProblem = [];
        }
      } else {
        $currentProblem[] = $columnData;
      }
    }

    // Don't forget the last problem
    if (!empty($currentProblem)) {
      $problems[] = $currentProblem;
    }

    return $problems;
  }

  private function calculateProblem(array $problemColumns): int {
    // Each problem has numbers arranged vertically
    // The last row contains the operator
    $numbers = [];
    $operator = null;

    // Read vertically - each column is one digit position of the numbers
    // The last row has the operator
    $numRows = count($problemColumns[0]);
    $lastRowIdx = $numRows - 1;

    // Get operator from last row
    foreach ($problemColumns as $colData) {
      $char = trim($colData[$lastRowIdx]);
      if ($char === '+' || $char === '*') {
        $operator = $char;
        break;
      }
    }

    // Parse numbers - they are arranged vertically, one number per row (except last row)
    for ($row = 0; $row < $lastRowIdx; $row++) {
      $numberStr = '';
      foreach ($problemColumns as $colData) {
        $char = $colData[$row];
        if ($char !== ' ') {
          $numberStr .= $char;
        }
      }
      $trimmed = trim($numberStr);
      if ($trimmed !== '') {
        $numbers[] = (int)$trimmed;
      }
    }

    // Calculate result based on operator
    if (empty($numbers) || $operator === null) {
      return 0;
    }

    $result = $numbers[0];
    for ($i = 1; $i < count($numbers); $i++) {
      if ($operator === '+') {
        $result += $numbers[$i];
      } else if ($operator === '*') {
        $result *= $numbers[$i];
      }
    }

    return $result;
  }
}
