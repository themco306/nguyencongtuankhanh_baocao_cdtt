<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $title = 'Admin_TK';
        return view('backend.dashboard.index', compact('title'));
    }
}
