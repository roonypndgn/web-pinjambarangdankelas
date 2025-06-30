<?php

namespace App\Http\Controllers;
use PDF;
use App\Models\Pinjam;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MemberInvoiceController extends Controller
{
    public function invoicePdf($id)
{
    $peminjaman = Pinjam::with('barang', 'user')
        ->where('user_id', Auth::id())
        ->findOrFail($id);

    $pdf = Pdf::loadView('member.invoice.index', compact('peminjaman'))
              ->setPaper('A4', 'portrait');

    return $pdf->download('invoice-peminjaman.pdf');

}
}
