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

        return view('frontend.myaccount');
    }
}
