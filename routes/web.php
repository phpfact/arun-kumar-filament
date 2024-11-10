<?php

use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

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


    // dd(  refreshWallet( 1 )  );


    // return redirect()->route('home');
    return redirect('admin');
});

// Route::get('home', [LandingController::class, 'home'])->name('home');
