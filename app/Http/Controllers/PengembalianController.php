<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pinjam;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalians = Pengembalian::all();
        return view('admin.pengembalian.index', compact('pengembalians'));
    }

    public function create()
    {
        $peminjamans = Pengembalian::all(); // ambil data peminjaman untuk dropdown
        return view('pengembalian.create', compact('peminjamans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pinjam_id' => 'required|exists:peminjamans,id',
            'tgl_kembali' => 'required|date',
            'time_kembali' => 'required',
        ]);

        Pengembalian::create($request->all());

        return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        $peminjamans = Pinjam::all();
        return view('pengembalian.edit', compact('pengembalian', 'peminjamans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pinjam_id' => 'required|exists:peminjamans,id',
            'tgl_kembali' => 'required|date',
            'time_kembali' => 'required',
        ]);

        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->update($request->all());

        return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->delete();

        return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian berhasil dihapus.');
    }
}
