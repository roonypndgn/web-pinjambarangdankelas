<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function index()
    {
        return view('admin.admin');
    }
    function admin()
    {
        return view('admin.admin');
    }
    function member()
    {
        return view('admin.member');
    }
}
