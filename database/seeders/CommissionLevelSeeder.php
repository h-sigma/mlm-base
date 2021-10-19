<?php

namespace Database\Seeders;

use App\Models\CommissionLevel;
use Illuminate\Database\Seeder;

class CommissionLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CommissionLevel::query()->firstOrCreate(['level' => 0], [
            'level' => 0,
            'commission_percentage' => 0.80,
        ]);
        CommissionLevel::query()->firstOrCreate(['level' => 1], [
            'level' => 1,
            'commission_percentage' => 0.10,
        ]);
        CommissionLevel::query()->firstOrCreate(['level' => 2], [
            'level' => 2,
            'commission_percentage' => 0.05,
        ]);
        CommissionLevel::query()->firstOrCreate(['level' => 3], [
            'level' => 3,
            'commission_percentage' => 0.025,
        ]);
        CommissionLevel::query()->firstOrCreate(['level' => 4], [
            'level' => 4,
            'commission_percentage' => 0.0125,
        ]);
        CommissionLevel::query()->firstOrCreate(['level' => 5], [
            'level' => 5,
            'commission_percentage' => 0.0125,
        ]);
    }
}
