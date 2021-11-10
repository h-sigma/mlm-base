<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\PaymentAttempt;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PaymentAttemptController extends Controller
{
    public function index(User $user)
    {
        if (Auth::isAdminOrTargetUser($user)) {
            return $user->paymentAttempts;
        }
        return response()->json(['message' => 'Unauthorized.'], 403);
    }

    public function indexByInvoice(User $user, $invoiceId) {
        if(Auth::isAdminOrTargetUser($user)) {
            $invoice = Invoice::query()->with('paymentAttempts')->find($invoiceId);
            if(!$invoice) {
                return response()->json(['message' => 'Invoice Not Found.'], 404);
            }
            if($invoice->user_id == $user->id) {
                return $invoice->paymentAttempts;
            }
        }
        return response()->json(['message' => 'Unauthorized.'], 403);
    }

    public function show(User $user, $paymentId)
    {
        //todo -- add various payment types
        if(Auth::isAdminOrTargetUser($user)) {
            $payment = PaymentAttempt::query()->with('invoice')->find($paymentId);
            if(!$payment) {
                return response()->json(['message' => 'Payment Not Found.'], 404);
            }
            if($payment->invoice->user_id == $user->id) {
                return $payment;
            }
        }
        return response()->json(['message' => 'Unauthorized.'], 403);
    }
}
