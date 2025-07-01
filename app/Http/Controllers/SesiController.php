<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    function index()
    {
       return view('login');
    }
    function login(Request $request){
        $request->validate([
            'nim_nip' => 'required|numeric',
            'password' => 'required',
        ], [
            'nim_nip.required' => 'Masukkan NIM atau NIP tidak boleh kosong!',
            'nim_nip.numeric' => 'NIM atau NIP harus berupa angka!',
            'password.required' => 'Password tidak boleh kosong!',
        ]);

        $infologin=[
            'nim_nip' => $request->nim_nip,
            'password' => $request->password,
        ];
        if(Auth::attempt($infologin)){
            if(Auth::user()->jenis =='admin'){
                return redirect()->route('admin.dashboard');
            }elseif(Auth::user()->jenis =='member'){
                return redirect()->route('member.dashboard.index');
            }
        }else{
            return redirect('')->withErrors('Username dan password salah')->withInput();
        }
    }

    function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
