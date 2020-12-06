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

}
