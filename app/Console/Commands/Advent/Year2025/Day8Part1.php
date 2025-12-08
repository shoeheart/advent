<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2025;

use App\Console\AdventBase;

class EdgeHeap extends \SplMinHeap {
  protected function compare($value1, $value2): int {
    return $value2['dist'] <=> $value1['dist'];
  }
}

class Day8Part1 extends AdventBase
{
  protected $signature = 'year2025:day8part1 {--test : Use test input}';
  protected $description = 'Advent of Code 2025 Day 8 Part 1';

  private function _readTestInput() {
    $classPathReflect = new \ReflectionClass($this);
    $classPath = $classPathReflect->getFilename();
    $partIndex = strpos($classPath, "Part");
    $inputName = substr($classPath, 0, $partIndex) . '_test.input';
    return file($inputName, FILE_IGNORE_NEW_LINES);
  }

  public function handle() {
    $lines = $this->option('test') ? $this->_readTestInput() : $this->_readInput();

    // For testing, we want to make only 10 connections
    $maxConnections = $this->option('test') ? 10 : 1000;

    // Parse junction box positions
    $junctionBoxes = [];
    foreach ($lines as $line) {
      if (trim($line) === '') continue;
      $coords = array_map('intval', explode(',', $line));
      $junctionBoxes[] = $coords;
    }

    $numBoxes = count($junctionBoxes);
    echo "Total junction boxes: $numBoxes\n";

    // Use a min-heap to efficiently get shortest distances
    $heap = new EdgeHeap();

    echo "Calculating distances...\n";
    for ($i = 0; $i < $numBoxes; $i++) {
      if ($i % 100 == 0) {
        echo "Processing box $i/$numBoxes\n";
      }
      for ($j = $i + 1; $j < $numBoxes; $j++) {
        $dist = $this->distance($junctionBoxes[$i], $junctionBoxes[$j]);
        $heap->insert([
          'dist' => $dist,
          'i' => $i,
          'j' => $j
        ]);
      }
    }

    echo "Sorting complete. Processing connections...\n";

    // Use Union-Find to track circuits
    $parent = array_fill(0, $numBoxes, -1);
    $size = array_fill(0, $numBoxes, 1);

    $attemptsCount = 0;
    $successfulConnections = 0;

    while (!$heap->isEmpty() && $attemptsCount < $maxConnections) {
      $edge = $heap->extract();

      $i = $edge['i'];
      $j = $edge['j'];

      $rootI = $this->find($parent, $i);
      $rootJ = $this->find($parent, $j);

      $attemptsCount++;

      // If not in same circuit, connect them
      if ($rootI !== $rootJ) {
        $this->union($parent, $size, $rootI, $rootJ);
        $successfulConnections++;

        if ($this->option('test')) {
          echo "Attempt $attemptsCount (Success $successfulConnections): Box $i ({$junctionBoxes[$i][0]},{$junctionBoxes[$i][1]},{$junctionBoxes[$i][2]}) <-> Box $j ({$junctionBoxes[$j][0]},{$junctionBoxes[$j][1]},{$junctionBoxes[$j][2]}) [dist: {$edge['dist']}]\n";
        }
      } else {
        if ($this->option('test')) {
          echo "Attempt $attemptsCount (Skipped): Box $i and Box $j already connected\n";
        }
      }
    }

    echo "Made $successfulConnections successful connections out of $attemptsCount attempts\n";

    // Find all circuit sizes
    $circuits = [];
    for ($i = 0; $i < $numBoxes; $i++) {
      $root = $this->find($parent, $i);
      if (!isset($circuits[$root])) {
        $circuits[$root] = 0;
      }
      $circuits[$root]++;
    }

    $circuitSizes = array_values($circuits);
    rsort($circuitSizes);

    echo "Number of circuits: " . count($circuitSizes) . "\n";
    if ($this->option('test')) {
      echo "Circuit sizes: " . implode(', ', $circuitSizes) . "\n";
    }
    echo "Three largest circuits: " . implode(', ', array_slice($circuitSizes, 0, 3)) . "\n";

    $result = $circuitSizes[0] * $circuitSizes[1] * $circuitSizes[2];
    echo "Answer: $result\n";

    return parent::SUCCESS;
  }

  private function distance(array $p1, array $p2): float {
    $dx = $p1[0] - $p2[0];
    $dy = $p1[1] - $p2[1];
    $dz = $p1[2] - $p2[2];
    return sqrt($dx * $dx + $dy * $dy + $dz * $dz);
  }

  private function find(array &$parent, int $i): int {
    if ($parent[$i] === -1) {
      return $i;
    }
    // Path compression
    $parent[$i] = $this->find($parent, $parent[$i]);
    return $parent[$i];
  }

  private function union(array &$parent, array &$size, int $rootI, int $rootJ): void {
    // Union by size
    if ($size[$rootI] < $size[$rootJ]) {
      $parent[$rootI] = $rootJ;
      $size[$rootJ] += $size[$rootI];
    } else {
      $parent[$rootJ] = $rootI;
      $size[$rootI] += $size[$rootJ];
    }
  }
}
