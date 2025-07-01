<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\User;
use App\Models\Pinjam;
use App\Models\Pengembalian;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::sum('jumlah');
        $totalMember = User::where('jenis', 'member')->count();
        $totalPeminjamanAktif = Pinjam::where('status', 'pinjam')->count();
        $totalPengembalian = Pengembalian::count();
        $grafikData = Pinjam::selectRaw("strftime('%m', tgl_pinjam) as bulan, COUNT(*) as total")
            ->whereRaw("strftime('%Y', tgl_pinjam) = ?", [date('Y')])
            ->groupByRaw("strftime('%m', tgl_pinjam)")
            ->orderByRaw("strftime('%m', tgl_pinjam)")
            ->pluck('total', 'bulan')
            ->toArray();
        $grafikPeminjaman = [];
        for ($i = 1; $i <= 12; $i++) {
            $key = str_pad($i, 2, '0', STR_PAD_LEFT); // format 2 digit (01, 02, ...)
            $grafikPeminjaman[] = (int) ($grafikData[$key] ?? 0);
        }
        
        $barangPopuler = Barang::withCount('pinjams')
            ->orderByDesc('pinjams_count')
            ->first();

        $aktivitasPeminjaman = Pinjam::with('user', 'barang')
        ->orderByDesc('created_at')
        ->limit(5)
        ->get()
        ->map(function($item) {
            return [
                'tipe' => 'Peminjaman',
                'user' => $item->user->nama ?? '-',
                'barang' => $item->barang->merk ?? '-',
                'waktu' => $item->created_at,
                'deskripsi' => 'Peminjaman barang ' . ($item->barang->merk ?? '-') . ' oleh ' . ($item->user->nama ?? '-'),
            ];
        });

    $aktivitasPengembalian = Pengembalian::with('user', 'barang')
        ->orderByDesc('created_at')
        ->limit(5)
        ->get()
        ->map(function($item) {
            return [
                'tipe' => 'Pengembalian',
                'user' => $item->user->nama ?? '-',
                'barang' => $item->barang->merk ?? '-',
                'waktu' => $item->created_at,
                'deskripsi' => 'Pengembalian barang ' . ($item->barang->merk ?? '-') . ' oleh ' . ($item->user->nama ?? '-'),
            ];
        });

    $aktivitasTerkini = $aktivitasPeminjaman
        ->concat($aktivitasPengembalian)
        ->sortByDesc('waktu')
        ->take(5)
        ->values();

        return view('admin.dashboard.index', compact(
            'totalBarang',
            'totalMember',
            'totalPeminjamanAktif',
            'totalPengembalian',
            'grafikPeminjaman',
            'barangPopuler',
            'aktivitasTerkini'
        ));
    }
}