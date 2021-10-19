<?php

namespace Database\Seeders;

use App\Models\Commission;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $invoices = Invoice::with('user')->get();
        foreach($invoices as $invoice) {
            //debug -- commission 100% of invoice to self
            Commission::query()->firstOrCreate(['invoice_id' => $invoice->id], [
                'invoice_id' => $invoice->id,
                'user_id' => $invoice->user->id,
                'commission_percentage' => 1,
                'invoice_amount' => $invoice->amount,
                'balanced' => false
            ]);
        }
    }
}
