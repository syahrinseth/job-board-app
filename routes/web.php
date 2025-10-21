<?php

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Cashier;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Job Management Routes
Route::get('/job/create', [JobController::class, 'create'])
    ->middleware(['auth'])
    ->name('job.create');

Route::get('/checkout', function () {
    $stripePriceId = 'price_1SI91MR5jYwBOkncduNjVoXN'; // Replace with your actual price ID from Stripe
    $quantity = 1; // You can adjust the quantity as needed

    return request()->user()->checkout([$stripePriceId => $quantity], [
        'success_url' => route('checkout.success').'?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => route('checkout.cancel'),
        'metadata' => ['order_id' => auth()->id().'_'.time()],
    ]);
})->middleware(['auth'])->name('checkout');

Route::get('/checkout/success', function () {
    $sessionId = request('session_id');
    $session = Cashier::stripe()->checkout->sessions->retrieve($sessionId);
    if ($session->payment_status === 'paid') {
        // Payment was successful, you can perform post-payment actions here
    } else {
        // Payment was not successful, handle accordingly
    }

    return view('checkout.success');
})->name('checkout.success');

Route::get('/checkout/cancel', function () {
    return view('checkout.cancel');
})->name('checkout.cancel');

Route::post('/stripe/webhook', function (Request $request) {
    $sessionId = request('session_id');
    $session = Cashier::stripe()->checkout->sessions->retrieve($sessionId);
    if ($session->payment_status === 'paid') {
        // Payment was successful, you can perform post-payment actions here
    } else {
        // Payment was not successful, handle accordingly
    }
    Log::info($request->all());
})->name('stripe.webhook');

require __DIR__.'/auth.php';
