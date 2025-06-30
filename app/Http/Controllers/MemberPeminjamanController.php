<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pinjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MemberPeminjamanController extends Controller
{
    /**
     * Menampilkan daftar peminjaman member
     */
    public function index()
    {
        $peminjamans = Pinjam::with('barang')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        $barangs = Barang::where('status', 'tersedia')->get();
        $user = Auth::user();
        
        return view('member.peminjaman.index', compact('peminjamans','barangs','user'));
    }

    /**
     * Menampilkan form pengajuan peminjaman baru
     */
    public function create()
    {
        $barangs = Barang::where('status', 'tersedia')->get();
        return view('member.peminjaman.create', compact('barangs'));
    }

    /**
     * Menyimpan pengajuan peminjaman baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|integer|exists:barangs,id',
            'tgl_pinjam' => 'required|date|after_or_equal:today',
            'time_pinjam' => 'required',
        ], [
            'tgl_pinjam.after_or_equal' => 'Tanggal pinjam tidak boleh sebelum hari ini',
            'barang_id.exists' => 'Barang yang dipilih tidak valid'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Cek ketersediaan barang
            $barang = Barang::findOrFail($request->barang_id);
            if ($barang->status != 'tersedia') {
                return redirect()->back()
                    ->with('error', 'Barang tidak tersedia untuk dipinjam')
                    ->withInput();
            }

            // Buat pengajuan peminjaman dengan status pending
            Pinjam::create([
                'user_id' => Auth::id(),
                'barang_id' => $request->barang_id,
                'tgl_pinjam' => $request->tgl_pinjam,
                'time_pinjam' => $request->time_pinjam,
                'status' => 'pending' // Status awal menunggu persetujuan admin
            ]);

            return redirect()->route('member.peminjaman.index')
                ->with('success', 'Permintaan peminjaman berhasil diajukan. Menunggu persetujuan admin.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengajukan peminjaman: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menampilkan detail peminjaman
     */
    public function show($id)
    {
        $peminjaman = Pinjam::with('barang')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('member.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Membatalkan pengajuan peminjaman (hanya untuk status pending)
     */
    public function cancel($id)
    {
        try {
            $peminjaman = Pinjam::where('user_id', Auth::id())
                ->findOrFail($id);

            // Hanya bisa membatalkan jika status masih pending
            if ($peminjaman->status != 'pending') {
                return redirect()->back()
                    ->with('error', 'Hanya bisa membatalkan peminjaman yang belum diproses.');
            }

            $peminjaman->delete();

            return redirect()->route('member.peminjaman.index')
                ->with('success', 'Pengajuan peminjaman berhasil dibatalkan.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal membatalkan peminjaman: ' . $e->getMessage());
        }
    }
}
