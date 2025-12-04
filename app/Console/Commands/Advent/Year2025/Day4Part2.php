<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2025;

use App\Console\AdventBase;

class Day4Part2 extends AdventBase
{
  protected $signature = 'year2025:day4part2';
  protected $description = 'Advent of Code 2025 Day 4 Part 2';

  public function handle() {
    $lines = $this->_readInput();

    $grid = [];
    foreach ($lines as $line) {
      if (empty($line)) continue;
      $grid[] = str_split($line);
    }

    $rows = count($grid);
    $cols = count($grid[0]);
    $totalRemoved = 0;

    // Keep removing accessible rolls until no more can be removed
    while (true) {
      $accessible = $this->findAccessibleRolls($grid, $rows, $cols);

      if (empty($accessible)) {
        break;
      }

      // Remove all accessible rolls in this iteration
      foreach ($accessible as [$row, $col]) {
        $grid[$row][$col] = '.';
        $totalRemoved++;
      }

      echo "Removed " . count($accessible) . " rolls (total: $totalRemoved)\n";
    }

    echo "\nTotal rolls of paper removed: $totalRemoved\n";

    return parent::SUCCESS;
  }

  private function findAccessibleRolls(array $grid, int $rows, int $cols): array {
    $accessible = [];

    // Find all rolls that have fewer than 4 adjacent rolls
    for ($row = 0; $row < $rows; $row++) {
      for ($col = 0; $col < $cols; $col++) {
        if ($grid[$row][$col] === '@') {
          $adjacentCount = $this->countAdjacentRolls($grid, $row, $col, $rows, $cols);
          if ($adjacentCount < 4) {
            $accessible[] = [$row, $col];
          }
        }
      }
    }

    return $accessible;
  }

  private function countAdjacentRolls(array $grid, int $row, int $col, int $rows, int $cols): int {
    $count = 0;

    // Check all 8 adjacent positions
    $directions = [
      [-1, -1], [-1, 0], [-1, 1],  // top-left, top, top-right
      [0, -1],           [0, 1],    // left, right
      [1, -1],  [1, 0],  [1, 1]     // bottom-left, bottom, bottom-right
    ];

    foreach ($directions as [$dr, $dc]) {
      $newRow = $row + $dr;
      $newCol = $col + $dc;

      // Check if position is within bounds
      if ($newRow >= 0 && $newRow < $rows && $newCol >= 0 && $newCol < $cols) {
        if ($grid[$newRow][$newCol] === '@') {
          $count++;
        }
      }
    }

    return $count;
  }
}
