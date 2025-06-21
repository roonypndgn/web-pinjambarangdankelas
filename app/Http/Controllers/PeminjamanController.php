<?php

namespace App\Http\Controllers;

use App\Models\Pinjam;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeminjamanController extends Controller
{
    // Tampilkan semua data
    public function index()
    {
        $peminjamans = Pinjam::latest()->get();
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|integer',
            'user_id' => 'required|integer',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date',
            'time_pinjam' => 'required',
            'time_kembali' => 'required',
            'status' => 'required|in:dipinjam,dikembalikan'
        ]);

        Pinjam::create($request->all());

        return redirect()->route('peminjaman.index')->with('success', 'Data berhasil ditambahkan!');
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'required|integer',
            'user_id' => 'required|integer',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date',
            'time_pinjam' => 'required',
            'time_kembali' => 'required',
            'status' => 'required|in:dipinjam,dikembalikan'
        ]);

        $peminjaman = Pinjam::findOrFail($id);
        $peminjaman->update($request->all());

        return redirect()->route('peminjaman.index')->with('success', 'Data berhasil diupdate!');
    }

    // Hapus data
    public function destroy($id)
    {
        $peminjaman = Pinjam::findOrFail($id);
        $peminjaman->delete();

        return redirect()->route('peminjaman.index')->with('success', 'Data berhasil dihapus!');
    }
}
