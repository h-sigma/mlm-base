<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\PaymentAttempt;
use Illuminate\Database\Seeder;

class PaymentAttemptsSeeder extends Seeder
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
            PaymentAttempt::query()->firstOrCreate(['invoice_id' => $invoice->id, 'status' => 'Failed'], [
                'invoice_id' => $invoice->id,
                'status' => 'Failed',
                'status_reason' => 'Debug Fail',
                'payment_type' => 'Debug'
            ]);
            PaymentAttempt::query()->firstOrCreate(['invoice_id' => $invoice->id, 'status' => 'Cancelled'], [
                'invoice_id' => $invoice->id,
                'status' => 'Cancelled',
                'status_reason' => 'Debug Cancel',
                'payment_type' => 'Debug'
            ]);
            PaymentAttempt::query()->firstOrCreate(['invoice_id' => $invoice->id, 'status' => 'Succeeded'], [
                'invoice_id' => $invoice->id,
                'status' => 'Succeeded',
                'status_reason' => 'Debug Success',
                'payment_type' => 'Debug'
            ]);
        }
    }
}
