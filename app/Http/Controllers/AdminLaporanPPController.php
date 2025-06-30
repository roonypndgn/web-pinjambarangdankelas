<?php

namespace App\Http\Controllers;
use PDF;
use App\Models\Pinjam;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class AdminLaporanPPController extends Controller
{
    public function exportPdf()
{
    $peminjamans = Pinjam::with(['user', 'barang'])->latest()->get();

    $pdf = PDF::loadView('admin.laporanPeminjaman.index', compact('peminjamans'));
    return $pdf->download('laporan_peminjaman.pdf');
}
    public function exportPdfPengembalian()
    {
        $pengembalians = Pengembalian::with(['user', 'barang'])->latest()->get();
        $pdf = PDF::loadView('admin.laporanPengembalian.index', compact('pengembalians'));
        return $pdf->download('laporan_pengembalian.pdf');
    }
}
