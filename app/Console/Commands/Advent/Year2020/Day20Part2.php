<?php declare(strict_types=1);

namespace App\Console\Commands\Advent\Year2020;

use App\Console\Commands\Advent\AdventBase;

class Day20Part2 extends AdventBase {

  protected $signature = "year2020:day20part2";
  protected $description = "Advent Of Code 2020 Day 20 Part 2";
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

  protected function _flipTopToBottom($mat) {
    return array_reverse($mat);
  }

  protected function _flipLeftToRight($mat) {
    $height = count($mat);
    $matFlip = array();

    for ($y = 0; $y < $height; $y++) {
      $matFlip[] = strrev($mat[$y]);
    }

    return $matFlip;
  }

  protected function _permutations($tile) {
    $permutations = [];
    $permutations[$tile[0]] = $tile;
    $tile = $this->_rotate90($tile);
    $permutations[$tile[0]] = $tile;
    $tile = $this->_rotate90($tile);
    $permutations[$tile[0]] = $tile;
    $tile = $this->_rotate90($tile);
    $permutations[$tile[0]] = $tile;
    $tile = $this->_flipTopToBottom($tile);
    $permutations[$tile[0]] = $tile;
    $tile = $this->_rotate90($tile);
    $permutations[$tile[0]] = $tile;
    $tile = $this->_rotate90($tile);
    $permutations[$tile[0]] = $tile;
    $tile = $this->_rotate90($tile);
    $permutations[$tile[0]] = $tile;

    return $permutations;
  }

  protected function _attach($tile1ID, $tile2ID) {
    $edges1 = array_keys($this->_tiles[$tile1ID]['permutations']);
    $edges2 = array_keys($this->_tiles[$tile2ID]['permutations']);
    // echo "    comparing tile $tile1ID edges\n";
    // print_r($edges1);
    // echo "    against tile $tile2ID edges\n";
    // print_r($edges2);
    // echo "\n";

    foreach($edges1 as $i1 => $e1) {
      foreach($edges2 as $i2 => $e2) {
        if ($e1 == $e2) {
          // lock these tiles to the orientation that matched
          // if(isset($this->_tiles[$tile1ID]['oriented'])) {
          //   echo "      $tile1ID already oriented to " .
          //     $this->_tiles[$tile1ID]['oriented'] .
          //     " but trying to reorient to $e1\n";
          // } else {
          //   echo "      orienting $tile1ID to $e1\n";
          //   $this->_tiles[$tile1ID]['oriented'] = $e1;
          // }

          if (!array_key_exists($e1, $this->_tiles[$tile1ID]['connections'])) {
            $this->_tiles[$tile1ID]['connections'][$e1] = $tile2ID;
          }
          //if (!array_key_exists($e2, $this->_tiles[$tile2ID]['connections'])) {
            //$this->_tiles[$tile2ID]['connections'][$e2] = $tile1ID;
          //}

          // if(isset($this->_tiles[$tile2ID]['oriented'])) {
          //   echo "      $tile2ID already oriented to " .
          //     $this->_tiles[$tile2ID]['oriented'] .
          //     " but trying to reorient to $e2\n";
          // } else {
          //   echo "      orienting $tile2ID to $e2\n";
          //   $this->_tiles[$tile2ID]['oriented'] = $attach[0];
          // }

          // echo "      matched $tile1ID to $tile2ID\n";
          // print_r($this->_tiles[$tile1ID]['permutations'][$e1]);
          // $attach = $this->_flipTopToBottom($this->_tiles[$tile1ID]['permutations'][$e2]);
          // print_r($attach);
          // echo "\n";
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
        $this->_tiles[$tileID]['permutations'] = $this->_permutations($tile);
        $this->_tiles[$tileID]['connections'] = [];
      } elseif (preg_match('/Tile (\d+):/', $line, $matches)) {
        $tileID = $matches[1];
        $tile = [];
      } else {
        $tile[] = $line;
      }
    }
    $this->_tiles[$tileID]['permutations'] = $this->_permutations($tile);
    $this->_tiles[$tileID]['connections'] = [];

    //print_r($this->_tiles);
    //echo "\n";

    $corners = [];
    foreach($this->_tiles as $possibleCornerID => $_) {
      //echo "testing $possibleCornerID\n";
      $attachments = 0;
      foreach($this->_tiles as $possibleAttachmentID => $_) {
        //echo "  against $possibleAttachmentID\n";
        // can't attach ourself to ourself
        if ($possibleCornerID == $possibleAttachmentID) {
          //echo "    skipping self\n";
          continue;
        }
        if ($this->_attach($possibleCornerID, $possibleAttachmentID)) {
          //echo "  found match!!!\n";
          $attachments++;
        }
      }
      if ($attachments == 2) {
        $corners[] = $possibleCornerID;
      } elseif ($attachments == 3) {
        $borders[] = $possibleCornerID;
      } else {
        if ($attachments != 4) {
          echo "found $attachments to tile $possibleCornerID\n";
        }
        $middles[] = $possibleCornerID;
      }
    }

    echo "tiles after finding corners\n";
    print_r($this->_tiles);
    echo "\n";

    print_r($corners);
    echo "\n";
    $product = 1;
    foreach($corners as $corner) {
      $product = $product * $corner;
      echo "corner tile $corner:\n";
      print_r($this->_tiles[$corner]);
      echo "\n";
    }
    echo "product: $product\n";
    echo "borders: " . count($borders) . "\n";
    echo "middles: " . count($middles) . "\n";
    echo "total: " . count($this->_tiles) . "\n";

    // take first corner and rotate so connection are to right and down
    // do this by finding permutation that matches.  The next permutation in
    // the list will be the second connection, and is rotated 90 degrees right from
    // first connection's orientation and hence rotating first orientation
    // 90 degrees right twice will make this the top left corner
    $topLeft = $this->_tiles[$corners[0]];
    $boardTopLeft = array();
    foreach ($topLeft['connections'] as $connectionEdge => $connectionID) {
      $found = false;
      if (array_key_exists($permutationEdge, $topLeft['permutations'])) {
        // first one found is bottom edge
        if (!$found) {
          $mat = $this->_rotate90($permutationLines);
          $mat = $this->_rotate90($mat);
          $board[] = [];
          $board[0][] = array(
            'down' => $permutationEdge,
            'lines' => $mat,
          );
          $found = true;
        } else {
          $board[0][0]['right'] = $permutationEdge;
        }
      }
    }

    print_r($board);
  }
}
