<?php
// app/Http/Controllers/MemberBarangController.php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Barang;

class MemberBarangController extends Controller
{
    public function index(Request $request)
{
    $query = Barang::with('kategori');

    // Filter kategori jika ada
    if ($request->filled('kategori')) {
        $query->where('kategori_id', $request->kategori);
    }

    // Pencarian
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('merk', 'like', "%$search%")
              ->orWhere('deskripsi', 'like', "%$search%");
        });
    }

    $barangs = $query->latest()->paginate(12);
    $kategoris = Kategori::all(); // <-- Tambahkan baris ini
    $user = auth()->user();
    return view('member.barang.index', compact('barangs', 'kategoris','user'));
}
}
