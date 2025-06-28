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

        // Data Statistik
        $peminjamanAktif = Pinjam::where('user_id', $user->id)
            ->whereIn('status', ['dipinjam', 'proses'])
            ->count();

        $barangTersedia = Barang::where('status', 'tersedia')->count();

        $harusDikembalikan = Pinjam::where('user_id', $user->id)
        ->where('status', 'dipinjam')
        ->where('tgl_kembali', '<=', now())
        ->count();

        $riwayatPeminjaman = Pinjam::where('user_id', $user->id)
            ->where('status', 'selesai')
            ->count();
        
        // Barang Populer
        $barangPopuler = Barang::withCount('peminjamans')
            ->orderBy('peminjaman_count', 'desc')
            ->take(4)
            ->get();

        // Peminjaman Aktif
        $peminjamanAktifList = Pinjam::with('barang')
        ->where('user_id', $user->id)
        ->whereIn('status', ['dipinjam', 'proses'])
        ->orderBy('tgl_pinjam', 'desc')
        ->take(3)
        ->get();

        // Kategori untuk shortcut
        $kategoriPopuler = Kategori::withCount('barangs')
            ->orderBy('barang_count', 'desc')
            ->take(4)
            ->get();

        return view('member.dashboard.index', compact(
            'user',
            'peminjamanAktif',
            'barangTersedia',
            'harusDikembalikan',
            'riwayatPeminjaman',
            'barangPopuler',
            'peminjamanAktifList',
            'kategoriPopuler'
        ));
    }
    

}
