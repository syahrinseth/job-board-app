<?php

use App\Models\Job;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;

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
    $jobId = request()->input('job_id');

    if (empty($jobId)) {
        return abort(400);
    }

    return request()->user()->checkout([$stripePriceId => $quantity], [
        'success_url' => route('checkout.success').'?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => route('checkout.cancel'),
        'metadata' => ['order_id' => auth()->id().'_'.time(), 'job_id' => $jobId],
    ]);
})->middleware(['auth'])->name('checkout');

Route::get('/checkout/success', function () {
    $sessionId = request('session_id');
    $session = Cashier::stripe()->checkout->sessions->retrieve($sessionId);
    if ($session->payment_status === 'paid') {
        // Payment was successful, you can perform post-payment actions here
        // $jobId = $session->metadata->job_id;
        // Job::where('id', $jobId)->update(['status' => "Active"]);
    } else {
        // Payment was not successful, handle accordingly
    }

    return view('checkout.success');
})->name('checkout.success');

Route::get('/checkout/cancel', function () {
    return view('checkout.cancel');
})->name('checkout.cancel');

Route::post('/stripe/webhook', function (Request $request) {
    $payload = $request->getContent();
    $event = $payload ? json_decode($payload, true) : [];
    Log::info('Stripe Webhook Received: ', $event);

    if ($event['type'] == 'payment_intent.succeeded') {
        $paymentIntent = $event['data']['object'];
        $metadata = $paymentIntent['metadata'] ?? [];
        $jobId = isset($metadata['job_id']) ? $metadata['job_id'] : null;

        if ((config('app.env') === 'production' && $jobId) || config('app.env') === 'local') {
            if (empty($jobId)) {
                $jobId = Job::latest()->first()->id;
            }
            Job::where('id', $jobId)->update(['status' => "Active"]);
            Log::info("Job ID {$jobId} status updated to Active.");
        } else {
            Log::warning('No job_id found in payment intent metadata.');
        }
    }

    return response()->json(['status' => 'success']);
})->name('stripe.webhook');

require __DIR__.'/auth.php';
