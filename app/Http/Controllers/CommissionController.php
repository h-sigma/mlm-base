<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommissionController extends Controller
{
    public function generateCommissions()
    {
        //todo -- optimize
        Invoice::with('paymentAttempts')->doesntHave('commissions')->chunk(100, function ($invoices) {
            $invoicesToCommission = [];
            foreach ($invoices as $invoice) {
                foreach ($invoice->paymentAttempts as $paymentAttempt) {
                    if ($paymentAttempt->status === 'Succeeded') {
                        array_push($invoicesToCommission, $invoice);
                        break;
                    }
                }
            }
            //todo -- generate commissions
        });
    }

    public function balanceCommissions()
    {
        return DB::table('users')->join('commissions', 'users.id', '=', 'commissions.user_id')->where('commissions.balanced', '=', false)->dump()->update(['users.balance' => '`users`.`balance` + CAST(`commissions`.`invoice_amount` * `commissions`.`commission_percentage` AS decimal(12,4))']);
    }
}
