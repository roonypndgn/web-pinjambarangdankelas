<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index()
    {
        $members = \App\Models\User::where('jenis', 'member')->latest()->get();
        $recentMembers = \App\Models\User::where('jenis', 'member')->latest()->take(5)->get();
        return view('admin.member.index', compact('members', 'recentMembers'));
    }

    public function create()
    {
        return view('admin.member.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|unique:users',
            'nim_nip' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'nim_nip' => $request->nim_nip,
            'password' => Hash::make($request->password),
            'jenis' => 'member',
        ]);

        return redirect()->route('admin.member.index')->with('success', 'Member berhasil ditambahkan!');
    }

    public function edit(User $member)
    {
        return view('admin.member.edit', compact('member'));
    }

    public function update(Request $request, User $member)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:users,email,' . $member->id,
            'nim_nip' => 'required|string|max:20|unique:users,nim_nip,' . $member->id,
            'password' => 'required|string|min:6',
        ]);

        $member->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'nim_nip' => $request->nim_nip,
            'password' => $request->filled('password') ? Hash::make($request->password) : $member->password,
        ]);

        return redirect()->route('admin.member.index')->with('success', 'Member berhasil diperbarui!');
    }

    public function destroy(User $member)
    {
        $member->delete();
       return redirect()->route('admin.member.index')->with('success', 'Member berhasil dihapus!');
    }
}
