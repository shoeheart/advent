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
        \App\Console\Commands\Advent\TwentyTwenty\Day1Part1::class,
        \App\Console\Commands\Advent\TwentyTwenty\Day1Part2::class,
        \App\Console\Commands\Advent\TwentyTwenty\Day2Part1::class,
        \App\Console\Commands\Advent\TwentyTwenty\Day2Part2::class,
        \App\Console\Commands\Advent\TwentyTwenty\Day3Part1::class,
        \App\Console\Commands\Advent\TwentyTwenty\Day3Part2::class,
        \App\Console\Commands\Advent\TwentyTwenty\Day4Part1::class,
        \App\Console\Commands\Advent\TwentyTwenty\Day4Part2::class,
        //\App\Console\Commands\Advent\TwentyTwenty\Day5Part1::class,
        //\App\Console\Commands\Advent\TwentyTwenty\Day5Part2::class,
        //\App\Console\Commands\Advent\TwentyTwenty\Day6Part1::class,
        //\App\Console\Commands\Advent\TwentyTwenty\Day6Part2::class,
        //\App\Console\Commands\Advent\TwentyTwenty\Day7Part1::class,
        //\App\Console\Commands\Advent\TwentyTwenty\Day7Part2::class,
        //\App\Console\Commands\Advent\TwentyTwenty\Day8Part1::class,
        //\App\Console\Commands\Advent\TwentyTwenty\Day8Part2::class,
        //\App\Console\Commands\Advent\TwentyTwenty\Day9Part1::class,
        //\App\Console\Commands\Advent\TwentyTwenty\Day9Part2::class,
        //\App\Console\Commands\Advent\TwentyTwenty\Day10Part1::class,
        //\App\Console\Commands\Advent\TwentyTwenty\Day10Part2::class,
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
