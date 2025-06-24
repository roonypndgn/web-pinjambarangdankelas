<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberPengembalianController extends Controller
{
    // Menampilkan daftar status pengembalian barang milik member yang sedang login
    public function index()
    {
        $userId = Auth::id();

        // Asumsi relasi: Pengembalian -> Pinjam -> user_id
        $pengembalians = Pengembalian::whereHas('pinjam', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with('pinjam')->latest()->get();

        return view('member.pengembalian.index', compact('pengembalians'));
    }

    // Menampilkan detail status pengembalian (opsional)
    public function show(Pengembalian $pengembalian)
    {
        // Pastikan hanya pemilik yang bisa melihat detailnya
        if ($pengembalian->pinjam->user_id !== Auth::id()) {
            abort(403);
        }
        return view('member.pengembalian.show', compact('pengembalian'));
    }
}
