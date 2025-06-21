<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
       if (Auth::user()->jenis == 'admin') {
        // Tampilkan dashboard admin
        return view('admin.dashboard.admin');
    } else {
        // Redirect ke dashboard member
        return redirect()->route('member.dashboard');
    }
}
}

