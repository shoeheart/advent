<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2025;

use App\Console\AdventBase;

class EdgeHeap2 extends \SplMinHeap {
  protected function compare($value1, $value2): int {
    return $value2['dist'] <=> $value1['dist'];
  }
}

class Day8Part2 extends AdventBase
{
  protected $signature = 'year2025:day8part2 {--test : Use test input}';
  protected $description = 'Advent of Code 2025 Day 8 Part 2';

  private function _readTestInput() {
    $classPathReflect = new \ReflectionClass($this);
    $classPath = $classPathReflect->getFilename();
    $partIndex = strpos($classPath, "Part");
    $inputName = substr($classPath, 0, $partIndex) . '_test.input';
    return file($inputName, FILE_IGNORE_NEW_LINES);
  }

  public function handle() {
    $lines = $this->option('test') ? $this->_readTestInput() : $this->_readInput();

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
    $heap = new EdgeHeap2();

    echo "Calculating distances...\n";
    for ($i = 0; $i < $numBoxes; $i++) {
      if ($i % 100 == 0 && !$this->option('test')) {
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

    $successfulConnections = 0;
    $numCircuits = $numBoxes;
    $lastConnection = null;

    while (!$heap->isEmpty() && $numCircuits > 1) {
      $edge = $heap->extract();

      $i = $edge['i'];
      $j = $edge['j'];

      $rootI = $this->find($parent, $i);
      $rootJ = $this->find($parent, $j);

      // If not in same circuit, connect them
      if ($rootI !== $rootJ) {
        $this->union($parent, $size, $rootI, $rootJ);
        $successfulConnections++;
        $numCircuits--;

        // Track this as the last connection
        $lastConnection = [
          'i' => $i,
          'j' => $j,
          'dist' => $edge['dist']
        ];

        if ($this->option('test')) {
          echo "Connection $successfulConnections: Box $i ({$junctionBoxes[$i][0]},{$junctionBoxes[$i][1]},{$junctionBoxes[$i][2]}) <-> Box $j ({$junctionBoxes[$j][0]},{$junctionBoxes[$j][1]},{$junctionBoxes[$j][2]}) [dist: {$edge['dist']}] - Circuits remaining: $numCircuits\n";
        }
      }
    }

    echo "Made $successfulConnections successful connections\n";
    echo "Final number of circuits: $numCircuits\n";

    if ($lastConnection) {
      $i = $lastConnection['i'];
      $j = $lastConnection['j'];
      $x1 = $junctionBoxes[$i][0];
      $x2 = $junctionBoxes[$j][0];

      echo "Last connection: Box $i ($x1,{$junctionBoxes[$i][1]},{$junctionBoxes[$i][2]}) <-> Box $j ($x2,{$junctionBoxes[$j][1]},{$junctionBoxes[$j][2]})\n";
      echo "X coordinates: $x1 and $x2\n";

      $result = $x1 * $x2;
      echo "Answer: $result\n";
    } else {
      echo "No connections made!\n";
    }

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
