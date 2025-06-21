<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function index()
    {
        return view('layout.admin');
    }
    function admin()
    {
        return view('layout.admin');
    }
    function member()
    {
        return view('layout.member');
    }
}
