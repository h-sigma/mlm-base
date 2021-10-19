<?php

namespace Database\Seeders;

use App\Http\Controllers\CommissionController;
use App\Models\PaymentAttempt;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RewardSeeder::class);
        $this->call(CommissionLevelSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(InvoiceSeeder::class);
        $this->call(PaymentAttemptsSeeder::class);
        $this->call(CommissionSeeder::class);
    }
}
