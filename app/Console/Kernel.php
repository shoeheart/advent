<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Advent\Year2020\Day1Part1::class,
        \App\Console\Commands\Advent\Year2020\Day1Part2::class,
        \App\Console\Commands\Advent\Year2020\Day2Part1::class,
        \App\Console\Commands\Advent\Year2020\Day2Part2::class,
        \App\Console\Commands\Advent\Year2020\Day3Part1::class,
        \App\Console\Commands\Advent\Year2020\Day3Part2::class,
        \App\Console\Commands\Advent\Year2020\Day4Part1::class,
        \App\Console\Commands\Advent\Year2020\Day4Part2::class,
        \App\Console\Commands\Advent\Year2020\Day5Part1::class,
        \App\Console\Commands\Advent\Year2020\Day5Part2::class,
        \App\Console\Commands\Advent\Year2020\Day6Part1::class,
        \App\Console\Commands\Advent\Year2020\Day6Part2::class,
        \App\Console\Commands\Advent\Year2020\Day7Part1::class,
        \App\Console\Commands\Advent\Year2020\Day7Part2::class,
        \App\Console\Commands\Advent\Year2020\Day8Part1::class,
        \App\Console\Commands\Advent\Year2020\Day8Part2::class,
        \App\Console\Commands\Advent\Year2020\Day9Part1::class,
        \App\Console\Commands\Advent\Year2020\Day9Part2::class,
        \App\Console\Commands\Advent\Year2020\Day10Part1::class,
        \App\Console\Commands\Advent\Year2020\Day10Part2::class,
        \App\Console\Commands\Advent\Year2020\Day11Part1::class,
        \App\Console\Commands\Advent\Year2020\Day11Part2::class,
        \App\Console\Commands\Advent\Year2020\Day12Part1::class,
        \App\Console\Commands\Advent\Year2020\Day12Part2::class,
        \App\Console\Commands\Advent\Year2020\Day13Part1::class,
        \App\Console\Commands\Advent\Year2020\Day13Part2::class,
        \App\Console\Commands\Advent\Year2020\Day14Part1::class,
        \App\Console\Commands\Advent\Year2020\Day14Part2::class,
        \App\Console\Commands\Advent\Year2020\Day15Part1::class,
        \App\Console\Commands\Advent\Year2020\Day15Part2::class,
        //\App\Console\Commands\Advent\Year2020\Day16Part1::class,
        //\App\Console\Commands\Advent\Year2020\Day16Part2::class,
        //\App\Console\Commands\Advent\Year2020\Day17Part1::class,
        //\App\Console\Commands\Advent\Year2020\Day17Part2::class,
        //\App\Console\Commands\Advent\Year2020\Day18Part1::class,
        //\App\Console\Commands\Advent\Year2020\Day18Part2::class,
        //\App\Console\Commands\Advent\Year2020\Day19Part1::class,
        //\App\Console\Commands\Advent\Year2020\Day19Part2::class,
        //\App\Console\Commands\Advent\Year2020\Day20Part1::class,
        //\App\Console\Commands\Advent\Year2020\Day20Part2::class,
        //\App\Console\Commands\Advent\Year2020\Day21Part1::class,
        //\App\Console\Commands\Advent\Year2020\Day21Part2::class,
        //\App\Console\Commands\Advent\Year2020\Day22Part1::class,
        //\App\Console\Commands\Advent\Year2020\Day22Part2::class,
        //\App\Console\Commands\Advent\Year2020\Day23Part1::class,
        //\App\Console\Commands\Advent\Year2020\Day23Part2::class,
        //\App\Console\Commands\Advent\Year2020\Day24Part1::class,
        //\App\Console\Commands\Advent\Year2020\Day24Part2::class,
        //\App\Console\Commands\Advent\Year2020\Day25Part1::class,
        //\App\Console\Commands\Advent\Year2020\Day25Part2::class,
        \App\Console\Commands\Advent\Year2019\Day1Part1::class,
        \App\Console\Commands\Advent\Year2019\Day1Part2::class,
        \App\Console\Commands\Advent\Year2019\Day2Part1::class,
        \App\Console\Commands\Advent\Year2019\Day2Part2::class,
        //\App\Console\Commands\Advent\Year2019\Day3Part1::class,
        //\App\Console\Commands\Advent\Year2019\Day3Part2::class,
        //\App\Console\Commands\Advent\Year2019\Day4Part1::class,
        //\App\Console\Commands\Advent\Year2019\Day4Part2::class,
        //\App\Console\Commands\Advent\Year2019\Day5Part1::class,
        //\App\Console\Commands\Advent\Year2019\Day5Part2::class,
        //\App\Console\Commands\Advent\Year2019\Day6Part1::class,
        //\App\Console\Commands\Advent\Year2019\Day6Part2::class,
        //\App\Console\Commands\Advent\Year2019\Day7Part1::class,
        //\App\Console\Commands\Advent\Year2019\Day7Part2::class,
        //\App\Console\Commands\Advent\Year2019\Day8Part1::class,
        //\App\Console\Commands\Advent\Year2019\Day8Part2::class,
        //\App\Console\Commands\Advent\Year2019\Day9Part1::class,
        //\App\Console\Commands\Advent\Year2019\Day9Part2::class,
        //\App\Console\Commands\Advent\Year2019\Day10Part1::class,
        //\App\Console\Commands\Advent\Year2019\Day10Part2::class,
        //\App\Console\Commands\Advent\Year2019\Day11Part1::class,
        //\App\Console\Commands\Advent\Year2019\Day11Part2::class,
        //\App\Console\Commands\Advent\Year2019\Day12Part1::class,
        //\App\Console\Commands\Advent\Year2019\Day12Part2::class,
        //\App\Console\Commands\Advent\Year2019\Day13Part1::class,
        //\App\Console\Commands\Advent\Year2019\Day13Part2::class,
        //\App\Console\Commands\Advent\Year2019\Day14Part1::class,
        //\App\Console\Commands\Advent\Year2019\Day14Part2::class,
        //\App\Console\Commands\Advent\Year2019\Day15Part1::class,
        //\App\Console\Commands\Advent\Year2019\Day15Part2::class,
        //\App\Console\Commands\Advent\Year2019\Day16Part1::class,
        //\App\Console\Commands\Advent\Year2019\Day16Part2::class,
        //\App\Console\Commands\Advent\Year2019\Day17Part1::class,
        //\App\Console\Commands\Advent\Year2019\Day17Part2::class,
        //\App\Console\Commands\Advent\Year2019\Day18Part1::class,
        //\App\Console\Commands\Advent\Year2019\Day18Part2::class,
        //\App\Console\Commands\Advent\Year2019\Day19Part1::class,
        //\App\Console\Commands\Advent\Year2019\Day19Part2::class,
        //\App\Console\Commands\Advent\Year2019\Day20Part1::class,
        //\App\Console\Commands\Advent\Year2019\Day20Part2::class,
        //\App\Console\Commands\Advent\Year2019\Day21Part1::class,
        //\App\Console\Commands\Advent\Year2019\Day21Part2::class,
        //\App\Console\Commands\Advent\Year2019\Day22Part1::class,
        //\App\Console\Commands\Advent\Year2019\Day22Part2::class,
        //\App\Console\Commands\Advent\Year2019\Day23Part1::class,
        //\App\Console\Commands\Advent\Year2019\Day23Part2::class,
        //\App\Console\Commands\Advent\Year2019\Day24Part1::class,
        //\App\Console\Commands\Advent\Year2019\Day24Part2::class,
        //\App\Console\Commands\Advent\Year2019\Day25Part1::class,
        //\App\Console\Commands\Advent\Year2019\Day25Part2::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }
}
