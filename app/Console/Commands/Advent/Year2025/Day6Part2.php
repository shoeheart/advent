<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2025;

use App\Console\AdventBase;

class Day6Part2 extends AdventBase
{
  protected $signature = 'year2025:day6part2';
  protected $description = 'Advent of Code 2025 Day 6 Part 2';

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

    // Extract problems from columns (reading right-to-left)
    $problems = $this->extractProblems(array_reverse($columns, true));

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
    // Part 2: Each COLUMN represents one complete number
    // Read vertically top-to-bottom (most significant digit at top)
    $numbers = [];
    $operator = null;

    $numRows = count($problemColumns[0]);
    $lastRowIdx = $numRows - 1;

    // Process each column as a separate number
    foreach ($problemColumns as $colData) {
      // Check if last character is operator
      $lastChar = trim($colData[$lastRowIdx]);
      if ($lastChar === '+' || $lastChar === '*') {
        $operator = $lastChar;
        // Don't continue - still need to read the number from this column!
      }

      // Read digits vertically from top to bottom to form the number
      $numberStr = '';
      for ($row = 0; $row < $lastRowIdx; $row++) {
        $char = $colData[$row];
        if ($char !== ' ') {
          $numberStr .= $char;
        }
      }

      if ($numberStr !== '') {
        $numbers[] = (int)$numberStr;
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
