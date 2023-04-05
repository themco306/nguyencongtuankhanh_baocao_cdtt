<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function myaccount()
    {
        $user = Auth::guard('users')->user();
        return view('frontend.customer.myaccount', compact('user'));
    }
    public function edit()
    {
        $user = Auth::guard('users')->user();
        return view('frontend.customer.myaccount-edit', compact('user'));
    }
    public function order()
    {
        $user = Auth::guard('users')->user();
        return view('frontend.customer.myaccount-order', compact('user'));
    }
    public function address()
    {
        $user = Auth::guard('users')->user();
        return view('frontend.customer.myaccount-address', compact('user'));
    }
    public function wishlist()
    {
        $user = Auth::guard('users')->user();
        return view('frontend.customer.myaccount-wishlist', compact('user'));
    }
}
