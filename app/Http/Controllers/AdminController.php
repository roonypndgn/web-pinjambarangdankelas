<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function index()
    {
        return view('layouts.app');
    }
    function admin()
    {
        return view('layouts.app');
    }
    function member()
    {
        return view('admin.member');
    }
}
