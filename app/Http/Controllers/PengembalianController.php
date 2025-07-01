<?php

namespace App\Http\Controllers;

use App\Models\Pinjam;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalians = Pengembalian::with(['pinjam.barang', 'pinjam.user'])
            ->latest()
            ->paginate(10);

        $peminjamans = Pinjam::with(['barang', 'user'])
            ->where('status', 'pinjam')
            ->get();

        return view('admin.pengembalian.index', compact('pengembalians', 'peminjamans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pinjam_id' => 'required|exists:pinjams,id',
            'tgl_kembali' => 'required|date',
            'time_kembali' => 'required'
        ]);
        
        // Buat pengembalian
        $pengembalian = Pengembalian::create($request->all());

        // Update status peminjaman
        Pinjam::where('id', $request->pinjam_id)
            ->update(['status' => 'selesai']);

        // Update stok dan status barang
        $pinjam = Pinjam::find($request->pinjam_id);
        $barang = $pinjam->barang;
        $barang->increment('jumlah');

        // Jika stok > 0, ubah status ke 'tersedia'
        if ($barang->jumlah > 0) {
            $barang->update(['status' => 'tersedia']);
        }
        return redirect()->route('admin.pengembalian.index')
            ->with('success', 'Pengembalian berhasil dicatat');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tgl_kembali' => 'required|date',
            'time_kembali' => 'required'
        ]);

        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->update($request->all());

        return redirect()->route('admin.pengembalian.index')
            ->with('success', 'Data pengembalian berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->delete();

        return redirect()->route('admin.pengembalian.index')
            ->with('success', 'Data pengembalian berhasil dihapus');
    }
};