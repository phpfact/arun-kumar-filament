<?php

namespace App\Http\Controllers;

use Filament\Facades\Filament;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function home(Request $request){
        $data['isLoggedIn'] = isCustomerLoggedIn();
        return view('home')->with($data);
    }
}
