<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FlushSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:flush';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush sessions';

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
     * @return mixed
     */
    public function handle()
    {
        \Session::flush();
    }
}
