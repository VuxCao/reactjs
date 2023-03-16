<?php

namespace App\Console\Commands;

use App\Scraper\ListJob;
use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;

class ImportJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $db;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DatabaseManager $db)
    {
        parent::__construct();
        $this->db = $db;
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $bot = new ListJob($this->db);
        $bot->scrape();
    }
}
