<?php

namespace App\Http\Controllers;

use App\Models\Redemption;
use App\Models\Reward;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RedemptionController extends Controller
{
    public function index(User $user)
    {
        if (Auth::isAdminOrTargetUser($user)) {
            return $user->redemptions;
        }
        return response()->json(['message' => 'Unauthorized.'], 403);
    }

    public function store(Request $request, User $user)
    {
        //find reward
        $reward = Reward::query()->find($request->reward_id);
        if (!$reward) {
            return response()->json(['message' => 'Reward resource not found.'], 404);
        }

        //check authorization and available balance
        if (!($authenticatedUser = Auth::isAdminOrTargetUser($user))) {
            return response()->json(['message' => 'Unauthorized.', 'failed' => true], 403);
        } else if ($user->balance < $reward->cost) {
            return response()->json(['message' => 'Not enough balance.', 'failed' => true], 200);
        }

        //redeemer id is required to know who redeemed this reward -- an admin may do it on another user's behalf.
        DB::beginTransaction();
        $redemption = Redemption::query()->create([
            'reward_id' => $reward->id,
            'cost' => $reward->cost,
            'user_id' => $user->id,
            'redeemer_id' => $authenticatedUser->id
        ]);
        if ($redemption) {
            $user->balance -= $reward->cost;
            $success = $user->save();
            if ($success) {
                DB::commit();
                if ($success) {
                    return response()->json(['message' => 'Successfully redeemed.', 'redemption' => $redemption], 200);
                }
            }
        }

        DB::rollBack();
        return response()->json(['message' => 'Failed to redeem item.'], 500);
    }
}
