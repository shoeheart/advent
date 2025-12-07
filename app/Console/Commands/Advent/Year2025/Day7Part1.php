<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2025;

use App\Console\AdventBase;

class Day7Part1 extends AdventBase
{
  protected $signature = 'year2025:day7part1';
  protected $description = 'Advent of Code 2025 Day 7 Part 1';

  public function handle() {
    $lines = $this->_readInput();

    // Build the grid
    $grid = [];
    $startCol = -1;
    $startRow = -1;

    foreach ($lines as $rowIdx => $line) {
      $grid[$rowIdx] = str_split($line);
      $sPos = strpos($line, 'S');
      if ($sPos !== false) {
        $startRow = $rowIdx;
        $startCol = $sPos;
      }
    }

    if ($startRow === -1 || $startCol === -1) {
      echo "Could not find starting position 'S'\n";
      return parent::FAILURE;
    }

    // Simulate the beam splitting
    $splitCount = $this->simulateBeams($grid, $startRow, $startCol);

    echo "Total beam splits: $splitCount\n";

    return parent::SUCCESS;
  }

  private function simulateBeams(array $grid, int $startRow, int $startCol): int {
    $splitCount = 0;
    $height = count($grid);
    $width = count($grid[0]);

    // Queue of beams to process: [row, col]
    // All beams move downward
    $beams = [[$startRow + 1, $startCol]];

    // Track visited positions to avoid infinite loops
    $visited = [];

    while (!empty($beams)) {
      $newBeams = [];

      foreach ($beams as $beam) {
        [$row, $col] = $beam;

        // Check bounds
        if ($row >= $height || $row < 0 || $col >= $width || $col < 0) {
          continue;
        }

        // Check if already visited
        $key = "$row,$col";
        if (isset($visited[$key])) {
          continue;
        }
        $visited[$key] = true;

        $cell = $grid[$row][$col];

        if ($cell === '^') {
          // Splitter! Count this split
          $splitCount++;

          // Create two new beams going left and right from the next row down
          $newBeams[] = [$row + 1, $col - 1]; // Left beam continues down
          $newBeams[] = [$row + 1, $col + 1]; // Right beam continues down
        } else {
          // Empty space, continue downward
          $newBeams[] = [$row + 1, $col];
        }
      }

      $beams = $newBeams;
    }

    return $splitCount;
  }
}
