<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentAttemptController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\RedemptionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/Error401', function() {
    return response()->json(['message' => 'Not Found.'], 401);
})->name('Error401');

Route::bind('user', function ($value, $route) {
    if(($id = intval($value)) === 0) {
        return User::query()->where(['email' => $value])->firstOrFail();
    } else {
        return User::query()->findOrFail($value);
    }
});

Route::middleware('guest')->group(function() {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);
});

Route::middleware('auth:sanctum')->group(function () {
    //user
    Route::get('/user', [UserController::class, 'showSelf']);
    Route::get('/users/{user}', [UserController::class, 'show'])->middleware('admin');
    Route::get('/users', [UserController::class, 'index'])->middleware('admin');

    //rewards
    Route::get('/rewards', [RewardController::class, 'index']);

    //redemptions
    Route::get('/users/{user}/redemptions', [RedemptionController::class, 'index']);
    Route::post('/users/{user}/redemptions', [RedemptionController::class, 'store']);

    //MLM info
    Route::get('/tree/{user}', [UserNetworkController::class, 'tree']);

    //invoices
    Route::get('/users/{user}/invoices', [InvoiceController::class, 'index']);
    Route::get('/users/{user}/invoices/{invoiceId}', [InvoiceController::class, 'show']);

    //payments
    Route::get('/users/{user}/payments', [PaymentAttemptController::class, 'index']);
    Route::get('/users/{user}/invoices/{invoiceId}/payments', [PaymentAttemptController::class, 'indexByInvoice']);
    Route::get('/users/{user}/payments/{paymentId}', [PaymentAttemptController::class, 'show']);
});