<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pinjam;
use App\Models\User;
use App\Services\NotificationService;
use App\Notifications\PeminjamanDisetujui;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar semua peminjaman
     */
    public function index()
    {
        $peminjamans = Pinjam::with(['user', 'barang'])->latest()->get();
        // Peminjaman yang menunggu persetujuan (dari member)
        $pendingPeminjamans = Pinjam::with(['user', 'barang'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(5, ['*'], 'pending_page');

        // Peminjaman aktif (baik dari admin maupun yang sudah disetujui)
        $activePeminjamans = Pinjam::with(['user', 'barang'])
            ->where('status', 'pinjam')
            ->latest()
            ->paginate(5, ['*'], 'active_page');

        // Peminjaman yang sudah selesai
        $completedPeminjamans = Pinjam::with(['user', 'barang'])
            ->where('status', 'selesai')
            ->latest()
            ->paginate(5, ['*'], 'completed_page');

        // Peminjaman yang ditolak
        $rejectedPeminjamans = Pinjam::with(['user', 'barang'])
            ->where('status', 'rejected')
            ->latest()
            ->paginate(5, ['*'], 'rejected_page');
        $recentPeminjamans = Pinjam::with(['user', 'barang'])
            ->latest()
            ->take(5)
            ->get();
        // Data untuk form tambah cepat
        $members = User::where('jenis', 'member')->get();
        $barangs = Barang::all();

        return view('admin.peminjaman.index', compact(
            'peminjamans',
            'pendingPeminjamans',
            'activePeminjamans',
            'completedPeminjamans',
            'rejectedPeminjamans',
            'recentPeminjamans',
            'members',
            'barangs'
        ));
    }

    /**
     * Menampilkan form tambah peminjaman langsung oleh admin
     */
    public function create()
    {
        $members = User::where('jenis', 'member')->get();
        $barangs = Barang::where('status', 'tersedia')->get();

        return view('admin.peminjaman.create', compact('members', 'barangs'));
    }

    /**
     * Menyimpan peminjaman langsung oleh admin
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|integer|exists:barangs,id',
            'user_id' => 'required|integer|exists:users,id',
            'tgl_pinjam' => 'required|date|after_or_equal:today',
            'time_pinjam' => 'required',
        ], [
            'tgl_pinjam.after_or_equal' => 'Tanggal pinjam tidak boleh sebelum hari ini',
            'barang_id.exists' => 'Barang yang dipilih tidak valid',
            'user_id.exists' => 'Member yang dipilih tidak valid'
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

            // Buat peminjaman langsung dengan status 'pinjam'
            Pinjam::create([
                'user_id' => $request->user_id,
                'barang_id' => $request->barang_id,
                'tgl_pinjam' => $request->tgl_pinjam,
                'time_pinjam' => $request->time_pinjam,
                'status' => 'pinjam' // Langsung aktif tanpa persetujuan
            ]);

            // Update status barang
            $barang->update(['status' => 'dipinjam']);

            return redirect()->route('admin.peminjaman.index')
                ->with('success', 'Peminjaman berhasil ditambahkan langsung.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan peminjaman: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menyetujui peminjaman dari member
     */
    public function approve($id)
    {
        try {
            $peminjaman = Pinjam::findOrFail($id);

            // Validasi status
            if ($peminjaman->status != 'pending') {
                return redirect()->back()
                    ->with('error', 'Peminjaman ini sudah diproses sebelumnya.');
            }

            // Cek ketersediaan barang
            if ($peminjaman->barang->status != 'tersedia') {
                return redirect()->back()
                    ->with('error', 'Barang tidak tersedia untuk dipinjam');
            }


            // Update status peminjaman
            $peminjaman->update(['status' => 'approved']);

            return redirect()->route('admin.peminjaman.index')
                ->with('success', 'Peminjaman berhasil disetujui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyetujui peminjaman: ' . $e->getMessage());
        }
    }

    /**
     * Menolak peminjaman dari member
     */
    public function reject(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'admin_notes' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $peminjaman = Pinjam::findOrFail($id);

            // Validasi status
            if ($peminjaman->status != 'pending') {
                return redirect()->back()
                    ->with('error', 'Peminjaman ini sudah diproses sebelumnya.');
            }

            // Update status peminjaman
            $peminjaman->update([
                'status' => 'rejected',
                'admin_notes' => $request->admin_notes
            ]);

            return redirect()->route('admin.peminjaman.index')
                ->with('success', 'Peminjaman berhasil ditolak.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menolak peminjaman: ' . $e->getMessage());
        }
    }

    /**
     * Mengkonfirmasi peminjaman yang sudah disetujui
     */
    public function confirm($id)
    {
        try {
            $peminjaman = Pinjam::findOrFail($id);

            // Validasi status
            if ($peminjaman->status != 'approved') {
                return redirect()->back()
                    ->with('error', 'Hanya peminjaman yang sudah disetujui yang bisa dikonfirmasi.');
            }

            // Cek ketersediaan barang
            if ($peminjaman->barang->status != 'tersedia') {
                return redirect()->back()
                    ->with('error', 'Barang tidak tersedia untuk dipinjam');
            }

            // Update status peminjaman
            $peminjaman->update(['status' => 'pinjam']);

            // Update status barang
            $peminjaman->barang->update(['status' => 'dipinjam']);

            return redirect()->route('admin.peminjaman.index')
                ->with('success', 'Peminjaman berhasil dikonfirmasi. Barang telah dipinjam.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengkonfirmasi peminjaman: ' . $e->getMessage());
        }
    }

    /**
     * Menyelesaikan peminjaman
     */
    public function complete($id)
    {
        try {
            $peminjaman = Pinjam::findOrFail($id);

            // Validasi status
            if ($peminjaman->status != 'pinjam') {
                return redirect()->back()
                    ->with('error', 'Hanya peminjaman aktif yang bisa diselesaikan.');
            }

            // Update status peminjaman
            $peminjaman->update(['status' => 'selesai']);

            // Update status barang
            $peminjaman->barang->update(['status' => 'tersedia']);

            return redirect()->route('admin.peminjaman.index')
                ->with('success', 'Peminjaman berhasil diselesaikan. Barang telah dikembalikan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyelesaikan peminjaman: ' . $e->getMessage());
        }
    }
    /**
     * Menampilkan form edit peminjaman
     */
    public function update(Request $request, Pinjam $peminjaman)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'barang_id' => 'required|exists:barangs,id',
            'tgl_pinjam' => 'required|date',
            'time_pinjam' => 'required',
            'status' => 'required'
        ]);

        $peminjaman->update([
            'user_id' => $request->user_id,
            'barang_id' => $request->barang_id,
            'tgl_pinjam' => $request->tgl_pinjam,
            'time_pinjam' => $request->time_pinjam,
            'status' => $request->status,
            'admin_notes' => $request->admin_notes ?? null,
        ]);

        return redirect()->route('admin.peminjaman.index')->with('success', 'Data peminjaman berhasil diupdate!');
    }
    /**
     * Menghapus data peminjaman
     */
    public function destroy($id)
    {
        try {
            $peminjaman = Pinjam::findOrFail($id);

            // Jika peminjaman aktif, kembalikan barang terlebih dahulu
            if ($peminjaman->status == 'pinjam') {
                $peminjaman->barang->update(['status' => 'tersedia']);
            }

            $peminjaman->delete();

            return redirect()->route('admin.peminjaman.index')
                ->with('success', 'Data peminjaman berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
