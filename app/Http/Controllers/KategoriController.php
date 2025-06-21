<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
    $kategoris = Kategori::latest()->paginate(10);
    $recentCategories = Kategori::with('user')->latest()->take(5)->get();
    
    return view('admin.kategori.index', compact('kategoris', 'recentCategories'));}

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string'
        ]);

        Kategori::create($request->all());
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string'
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->all());

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diupdate!');
    }

    // KategoriController.php
    public function destroy($id)
    {
    $kategori = Kategori::findOrFail($id);
    $kategori->delete();

    return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}
