<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberDashboardController extends Controller
{
    public function index()
    {
        // Ambil data statistik/member di sini jika perlu
        return view('member.dashboard.index');
    }
}