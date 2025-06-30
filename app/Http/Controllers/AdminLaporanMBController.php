<?php

namespace App\Http\Controllers;
use PDF;
use App\Models\Barang;
use App\Models\User;
use Illuminate\Http\Request;

class AdminLaporanMBController extends Controller
{
    public function exportPdf()
{
    $barangs = Barang::latest()->get();

    $pdf = PDF::loadView('admin.laporan.laporanbarang', compact('barangs'));
    return $pdf->download('laporan_barang.pdf');
}
    public function exportPdfMember()
    {
        $members = User::where('jenis', 'member')->latest()->get();

        $pdf = PDF::loadView('admin.laporan.laporanmember', compact('members'));
        return $pdf->download('laporan_member.pdf');
    }
}