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
}
