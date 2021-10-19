<?php

namespace App\Http\Controllers;

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

    public function show(User $user, $paymentId)
    {
        //todo -- add various payment types
        if(Auth::isAdminOrTargetUser($user)) {
            $payment = PaymentAttempt::query()->find($paymentId);
            if(!$payment) {
                return response()->json(['message' => 'Resource Not Found.'], 404);
            }
            if($payment->user_id == $user->id) {
                return $payment;
            }
        }
        return response()->json(['message' => 'Unauthorized.'], 403);
    }
}
