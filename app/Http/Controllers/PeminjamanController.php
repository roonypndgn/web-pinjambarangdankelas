<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pinjam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar peminjaman
     */
    public function index()
    {
        $peminjamans = Pinjam::with(['user', 'barang'])
            ->latest()
            ->paginate(10);

        $recentPeminjamans = Pinjam::with(['user', 'barang'])
            ->latest()
            ->take(5)
            ->get();

        $members = User::where('jenis', 'member')->get(); // Hanya ambil member
        $barangs = Barang::all();

        return view('admin.peminjaman.index', compact(
            'peminjamans',
            'recentPeminjamans',
            'members',
            'barangs'
        ));
    }

    /**
     * Menampilkan form tambah peminjaman
     */
    public function create()
    {
        $members = User::where('jenis', 'member')->get(); // Hanya ambil member
        $barangs = Barang::where('status', 'tersedia')->get(); // Hanya barang tersedia

        return view('admin.peminjaman.create', compact('members', 'barangs'));
    }

    /**
     * Menyimpan data peminjaman baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|integer|exists:barangs,id',
            'user_id' => 'required|integer|exists:users,id',
            'tgl_pinjam' => 'required|date|after_or_equal:today',
            'time_pinjam' => 'required',
            'status' => 'required|in:pinjam'
        ], [
            'tgl_pinjam.after_or_equal' => 'Tanggal pinjam tidak boleh sebelum hari ini'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Pinjam::create([
                'user_id' => $request->user_id,
                'barang_id' => $request->barang_id,
                'tgl_pinjam' => $request->tgl_pinjam,
                'time_pinjam' => $request->time_pinjam,
                'status' => 'pinjam'
            ]);

            Barang::where('id', $request->barang_id)
                ->update(['status' => 'dipinjam']);

            return redirect()->route('admin.peminjaman.index')->with('success', 'Data berhasil ditambahkan');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menampilkan form edit peminjaman
     */
    public function edit($id)
    {
        $peminjaman = Pinjam::findOrFail($id);
        $members = User::where('jenis', 'member')->get();
        $barangs = Barang::all();

        return view('admin.peminjaman.edit', compact('peminjaman', 'members', 'barangs'));
    }

    /**
     * Mengupdate data peminjaman
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|integer|exists:barangs,id',
            'user_id' => 'required|integer|exists:users,id',
            'tgl_pinjam' => 'required|date',
            'time_pinjam' => 'required',
            'status' => 'required|in:pinjam'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $peminjaman = Pinjam::findOrFail($id);
            $oldBarangId = $peminjaman->barang_id;

            $peminjaman->update([
                'user_id' => $request->user_id,
                'barang_id' => $request->barang_id,
                'tgl_pinjam' => $request->tgl_pinjam,
                'time_pinjam' => $request->time_pinjam,
                'status' => $request->status
            ]);

            if ($oldBarangId != $request->barang_id) {
                Barang::where('id', $oldBarangId)
                    ->update(['status' => 'tersedia']);
            }

            Barang::where('id', $request->barang_id)
                ->update(['status' => 'dipinjam']);

            return redirect()->route('admin.peminjaman.index')
                ->with('success', 'Data peminjaman berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menghapus data peminjaman
     */
    public function destroy($id)
    {
        try {
            $peminjaman = Pinjam::findOrFail($id);
            $barangId = $peminjaman->barang_id;

            $peminjaman->delete();

            Barang::where('id', $barangId)
                ->update(['status' => 'tersedia']);

            return redirect()->route('admin.peminjaman.index')
                ->with('success', 'Data peminjaman berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
