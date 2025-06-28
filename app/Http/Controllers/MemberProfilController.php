<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class MemberProfilController extends Controller
{
    /**
     * Tampilkan halaman profil member.
     */
    public function index()
    {
        $user = User::find(Auth::id());
        return view('member.dashboard.profile', compact('user'));
    }

    /**
     * Update data profil member.
     */
    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
         if ($request->hasFile('foto')) {
        // Hapus foto lama jika ada
        if ($user->foto && Storage::exists($user->foto)) {
            Storage::delete($user->foto);
        }

        $path = $request->file('foto')->store('foto_profil', 'public');
        $user->foto = $path;
    }

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->telepon = $request->telepon;
        $user->alamat = $request->alamat;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->save();
        
        return redirect()->route('member.dashboard.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Ganti password member.
     */
    public function changePassword(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('member.dashboard.profile')->with('success', 'Password berhasil diganti.');
    }
}