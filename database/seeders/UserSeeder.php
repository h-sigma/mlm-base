<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::query()->firstOrCreate(['email' => 'admin@admin'], [
            'email' => 'admin@admin',
            'password' => Hash::make('password'),
            'sponsor_id' => NULL,
            'name' => 'admin',
            'joining_invoice_id' => NULL,
            'admin' => true,
            'balance' => 6000
        ]);
    }
}
