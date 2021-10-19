<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    static $sensitive = ['email'];
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $didLogin = Auth::attempt($credentials);

        if (!$didLogin) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.', $credentials['email']],
                'password' => ['The provided credentials are incorrect.', Hash::make($credentials['password'])]
            ]);
        }

        return $this->GetTokenFromCurrentUser();
    }

    public function register(Request $request)
    {
        //todo -- add to tree network and create joining invoice
        $validated = $this->validate($request, [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|between:8,30|confirmed',
            'name' => 'required|max:50',
            'password_confirmation' => 'required|between:8,30',
            'sponsor_id' => 'exists:users,id'
        ]);

        DB::beginTransaction();
        DB::enableQueryLog();
        $user = User::query()->create(
            array_merge(
                $request->only('name', 'email', 'sponsor_id'),
                [
                    'password' => Hash::make($validated['password'])
                ]
            )
        );

        if (!$user || !Auth::attempt($validated)) {
            DB::rollBack();
            return response()->json(['message' => 'Input is not valid.'], '500');
        }

        $joiningInvoiceDetails = Config::get('constants.joining_invoice_details');
        $joiningInvoice = Invoice::query()->create([
            'amount' => $joiningInvoiceDetails['amount'],
            'description' => $joiningInvoiceDetails['description'],
            'user_id' => $user->id,
            'delivered_at' => Carbon::today()
        ]);

        if(!$joiningInvoice) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to generate invoice.'], '500');
        }

        $user->joining_invoice_id = $joiningInvoice->id;
        $user->save();

        DB::commit();
        return $this->GetTokenFromCurrentUser();
    }

    public function GetTokenFromCurrentUser(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $user->tokens()->delete();
        $token = $user->createToken('default_token');
        return response()->json(['token_id' => $token->plainTextToken], 200);
    }

    public function show(User $user)
    {
        return $user;
    }

    public function showSelf()
    {
        return Auth::user();
    }

    public function index()
    {
        return User::all();
    }
}
