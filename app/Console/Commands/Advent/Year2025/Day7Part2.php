<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2025;

use App\Console\AdventBase;

class Day7Part2 extends AdventBase
{
  protected $signature = 'year2025:day7part2';
  protected $description = 'Advent of Code 2025 Day 7 Part 2';

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

    // Count the number of unique timelines (final exit columns)
    $timelineCount = $this->countTimelines($grid, $startRow, $startCol);

    echo "Total timelines: $timelineCount\n";

    return parent::SUCCESS;
  }

  private function countTimelines(array $grid, int $startRow, int $startCol): int {
    $height = count($grid);
    $width = count($grid[0]);

    // Use dynamic programming: count the number of paths to each position
    // pathCount[row][col] = number of different paths that reach this position
    $pathCount = [];

    // Initialize the starting position
    $pathCount[0][$startCol] = 1;

    // Process row by row from top to bottom
    for ($row = 0; $row < $height; $row++) {
      if (!isset($pathCount[$row])) {
        continue;
      }

      foreach ($pathCount[$row] as $col => $count) {
        if ($count == 0) {
          continue;
        }

        // Check the next row down
        $nextRow = $row + 1;
        if ($nextRow >= $height) {
          continue;
        }

        $cell = $grid[$nextRow][$col];

        if ($cell === '^') {
          // Particle splits - paths go to left and right on next row
          $leftCol = $col - 1;
          $rightCol = $col + 1;

          if ($leftCol >= 0 && $leftCol < $width) {
            if (!isset($pathCount[$nextRow + 1][$leftCol])) {
              $pathCount[$nextRow + 1][$leftCol] = 0;
            }
            $pathCount[$nextRow + 1][$leftCol] += $count;
          }

          if ($rightCol >= 0 && $rightCol < $width) {
            if (!isset($pathCount[$nextRow + 1][$rightCol])) {
              $pathCount[$nextRow + 1][$rightCol] = 0;
            }
            $pathCount[$nextRow + 1][$rightCol] += $count;
          }
        } else {
          // Continue straight down
          if (!isset($pathCount[$nextRow][$col])) {
            $pathCount[$nextRow][$col] = 0;
          }
          $pathCount[$nextRow][$col] += $count;
        }
      }
    }

    // Sum up all paths that reached the last row or exited
    $totalPaths = 0;

    // Count paths in the last row
    if (isset($pathCount[$height - 1])) {
      foreach ($pathCount[$height - 1] as $count) {
        $totalPaths += $count;
      }
    }

    return $totalPaths;
  }
}
