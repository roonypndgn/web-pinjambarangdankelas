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
        // 1. Jumlah Barang
        $totalBarang = Barang::count();

        // 2. Jumlah Member
        $totalMember = User::where('jenis', 'member')->count();

        // 3. Jumlah Peminjaman yang Berlangsung (status dipinjam/proses)
        $totalPeminjamanBerlangsung = Pinjam::whereIn('status', ['dipinjam', 'proses'])->count();

        // 4. Jumlah Pengembalian
        $totalPengembalian = Pengembalian::count();

        // 5. Data Grafik Peminjaman per Bulan (12 bulan terakhir)
        $grafikData = Pinjam::selectRaw("strftime('%m', tgl_pinjam) as bulan, COUNT(*) as total")
            ->whereRaw("strftime('%Y', tgl_pinjam) = ?", [date('Y')])
            ->groupByRaw("strftime('%m', tgl_pinjam)")
            ->orderByRaw("strftime('%m', tgl_pinjam)")
            ->pluck('total', 'bulan')
            ->toArray();

        // Isi bulan yang belum ada agar 1-12 selalu terisi
        $grafikPeminjaman = [];
        for ($i = 1; $i <= 12; $i++) {
            $key = str_pad($i, 2, '0', STR_PAD_LEFT); // format 2 digit (01, 02, ...)
            $grafikPeminjaman[] = (int) ($grafikData[$key] ?? 0);
        }
        
        // 6. Informasi Menarik Lainnya (contoh: barang paling sering dipinjam)
        $barangPopuler = Barang::withCount('pinjams')
            ->orderByDesc('pinjams_count')
            ->first();

        $aktivitasPeminjaman = \App\Models\Pinjam::with('user', 'barang')
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

    $aktivitasPengembalian = \App\Models\Pengembalian::with('user', 'barang')
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

    // Gabungkan dan urutkan berdasarkan waktu terbaru
    $aktivitasTerkini = $aktivitasPeminjaman
        ->concat($aktivitasPengembalian)
        ->sortByDesc('waktu')
        ->take(5)
        ->values();

        return view('admin.dashboard.index', compact(
            'totalBarang',
            'totalMember',
            'totalPeminjamanBerlangsung',
            'totalPengembalian',
            'grafikPeminjaman',
            'barangPopuler',
            'aktivitasTerkini'
        ));
    }
}