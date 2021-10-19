<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{

    public function index(User $user)
    {
        if (Auth::isAdminOrTargetUser($user)) {
            return $user->invoices;
        }
        return response()->json(['message' => 'Unauthorized.'], 403);
    }

    public function show(User $user, $invoiceId)
    {
        if (Auth::isAdminOrTargetUser($user)) {
            $invoice = Invoice::query()->find($invoiceId);
            if (!$invoice) {
                return response()->json(['message' => 'Not Found.'], '404');
            }
            if ($invoice->user_id != $user->id) {
                return response()->json(['message' => 'Unauthorized.'], '404');
            }
            return $invoice;
        }
        return response()->json(['message' => 'Unauthorized.'], 403);
    }
}
