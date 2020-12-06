<?php

namespace App\Console\Commands\Advent;

use ReflectionClass;
use Illuminate\Console\Command;

class AdventBase extends Command {

  protected function _readInput() {
    $classPathReflect = new ReflectionClass($this);
    $classPath = $classPathReflect->getFilename();
    // remove Part portion since multiple parts share same input
    // on a given day
    $partIndex = strpos($classPath, "Part");
    $inputName = substr($classPath, 0, $partIndex) . '.input';
    return file($inputName, FILE_IGNORE_NEW_LINES);
  }

  // reads lines and adds each to an array until empty line encountered
  // Add that array of lines as first element in result array
  // and continued parsing to return array of arrays, where each
  // element in outer array is an array of lines in a group.
  protected function _readGroupedInput() {
    $lines = $this->_readInput();

    $groups = [];
    $currentGroup = [];
    foreach ($lines as $line) {
      if (empty($line)) {
        $groups[] = $currentGroup;
        $currentGroup = [];
      } else {
        $currentGroup[] = $line;
      }
    }
    $groups[] = $currentGroup;

    return $groups;
  }

  // for each line, explode based on separator, and put $itemsPerChunk
  // items into each array result.
  // Return array with one element per input line, and each value is
  // array of length $itemsPerChunk values
  protected function _readChunkedInput($itemsPerChunk, $separator = ',') {
    $lines = $this->_readInput();

    $result = [];
    foreach ($lines as $line) {
      $items = explode($separator, $line);
      $result[] = array_chunk($items, $itemsPerChunk);
    }
    return $result;
  }
}
