<?php

namespace App\Console\Commands;

use App\Http\Controllers\CommissionController;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateCommissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate_commissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        (new CommissionController)->generateCommissions();
        return Command::SUCCESS;
    }
}
