<?php

namespace Laravel\Spark\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Spark\Spark;

class VersionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spark:version';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View the current Spark version';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('<info>Laravel Spark</info> version <comment>'.Spark::$version.'</comment>');
    }
}
