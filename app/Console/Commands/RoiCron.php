<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RoiCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roi:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily ROI cron';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
