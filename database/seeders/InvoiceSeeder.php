<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $joiningInvoiceDetails = Config::get('constants.joining_invoice_details');
        foreach ($users as $user) {
            $invoice = Invoice::query()->firstOrCreate(['user_id' => $user->id], [
                'amount' => $joiningInvoiceDetails['amount'],
                'description' => $joiningInvoiceDetails['description'],
                'user_id' => $user->id,
                'delivered_at' => Carbon::now(),
            ]);
            $user->joining_invoice_id = $invoice->id;
            $user->save();
        }
    }
}
