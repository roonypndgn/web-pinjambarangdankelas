<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pinjam;
use App\Models\Pengembalian;
use App\Models\Barang;
use App\Models\Kategori;

class MemberDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $peminjamanAktif = Pinjam::where('user_id', $user->id)
            ->whereIn('status', ['pinjam', 'proses'])
            ->count(); 
        $barangTersedia = Barang::sum('jumlah');


        // Peminjaman Aktif
        $peminjamanAktifList = Pinjam::with('barang')
        ->where('user_id', $user->id)
        ->whereIn('status', ['pinjam', 'proses'])
        ->orderBy('tgl_pinjam', 'desc')
        ->take(3)
        ->get();
        $barangBaru = Barang::latest()->take(5)->get();
        return view('member.dashboard.index', compact(
            'user',
            'peminjamanAktif',
            'barangTersedia',
            'peminjamanAktifList',
            'barangBaru'
        ));
    }
    

}
