<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\Commands\Advent\AdventBase;

class Day20Part1 extends AdventBase {

  protected $signature = "year2020:day20part1";
  protected $description = "Advent Of Code 2020 Day 20 Part 1";
  protected $_tiles = [];

  protected function _rotate90($mat) {
    $height = count($mat);
    $width = strlen($mat[0]);
    $mat90 = array();

    for ($x = 0; $x < $width; $x++) {
        $line = '';
        for ($y = 0; $y < $height; $y++) {
            $line = $line . $mat[$height - $y - 1][$x];
        }
        $mat90[] = $line;
    }

    return $mat90;
  }

  protected function _flip($mat) {
    $height = count($mat);
    $matFlip = array();

    for ($y = 0; $y < $height; $y++) {
      $matFlip[] = strrev($mat[$y]);
    }

    return $matFlip;
  }

  // protected function _edges($mat) {
  //   $top = $mat[0];
  //   $rot90 = $this->_rotate90($mat);
  //   $left = $rot90[0];
  //   $rot90 = $this->_rotate90($mat);
  //   $bottom = $rot90[0];
  //   $rot90 = $this->_rotate90($mat);
  //   $right = $rot90[count($rot90) - 1];

  //   return array($top, $left, $bottom, $right)
  // }

  protected function _edges($tile) {
    $edges = [];
    $edges[] = $tile[0];
    $tile = $this->_rotate90($tile);
    $edges[] = $tile[0];
    $tile = $this->_rotate90($tile);
    $edges[] = $tile[0];
    $tile = $this->_rotate90($tile);
    $edges[] = $tile[0];
    $tile = $this->_flip($tile);
    $edges[] = $tile[0];
    $tile = $this->_rotate90($tile);
    $edges[] = $tile[0];
    $tile = $this->_rotate90($tile);
    $edges[] = $tile[0];
    $tile = $this->_rotate90($tile);
    $edges[] = $tile[0];

    return $edges;
  }

  protected function _canAttach($edges1, $edges2) {
    echo "    comparing edges\n";
    print_r($edges1);
    echo "    against edges\n";
    print_r($edges2);
    echo "\n";

    foreach($edges1 as $e1) {
      foreach($edges2 as $e2) {
        if ($e1 == $e2) {
          return true;
        }
      }
    }
    return false;
  }

  public function handle() {
    $lines = $this->_readInput();
    foreach($lines as $line) {
      if (empty($line)) {
        $this->_tiles[$tileID] =
          array(
            'lines' => $tile,
            'edges' => $this->_edges($tile),
          );
      } elseif (preg_match('/Tile (\d+):/', $line, $matches)) {
        $tileID = $matches[1];
        $tile = [];
      } else {
        $tile[] = $line;
      }
    }
    $this->_tiles[$tileID] =
      array(
        'lines' => $tile,
        'edges' => $this->_edges($tile),
      );

    //print_r($this->_tiles);
    //echo "\n";

    $corners = [];
    foreach($this->_tiles as $possibleCornerID => $possibleCorner) {
      echo "testing $possibleCornerID\n";
      $attachments = 0;
      foreach($this->_tiles as $possibleAttachmentID => $possibleAttachment) {
        echo "  against $possibleAttachmentID\n";
        // can't attach ourself to ourself
        if ($possibleCornerID == $possibleAttachmentID) {
          echo "    skipping self\n";
          continue;
        }
        if ($this->_canAttach($possibleCorner['edges'], $possibleAttachment['edges'])) {

          echo "  found match!!!\n";
          $attachments++;
        }
      }
      if ($attachments == 2) {
        $corners[] = $possibleCornerID;
      }
    }

    print_r($corners);
    echo "\n";
    $product = 1;
    foreach($corners as $corner) {
      $product = $product * $corner;
    }
    echo "product: $product\n";
  }
}
