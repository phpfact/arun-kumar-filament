<?php

use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Rupadana\FilamentAnnounce\Announce;
use App\Http\Controllers\LandingController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('admin');
});

Route::get('{month}/{year}/1/{day}/1/{random}/1/{customerId}', function ($month, $year, $day, $random, $customerId) {
    // Validate the signed URL
    if (!request()->hasValidSignature()) {
        abort(403, 'This URL has expired or is invalid.');
    }
    // Find the customer
    $customer = Customer::findOrFail($customerId);
    // Log in the customer using the appropriate guard
    Auth::guard('customer')->login($customer);
    // Redirect to the desired page
    return redirect('/customer/music/create');
})->name('customer.login.magic');
