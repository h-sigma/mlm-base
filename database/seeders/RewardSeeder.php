<?php

namespace Database\Seeders;

use App\Models\Reward;
use Illuminate\Database\Seeder;

class RewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reward::query()->firstOrCreate(['content_title' => 'Dubai Package'], [
            'cost' => 200,
            'content_title' => 'Dubai Package',
            'content_description' => '3 Days 3 Nights stay in Dubai.',
            'content_banner_image' => 'Banner Image'
        ]);
        Reward::query()->firstOrCreate(['content_title' => 'USA Package'], [
            'cost' => 600,
            'content_title' => 'USA Package',
            'content_description' => '7 Week USA Tour.',
            'content_banner_image' => 'Banner Image'
        ]);
    }
}
