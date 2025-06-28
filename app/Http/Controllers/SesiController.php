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
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email tidak boleh kosong!',
            'email.email' => 'Format email tidak valid!',
            'password.required' => 'Password tidak boleh kosong!',
        ]);

        $infologin=[
            'email' => $request->email,
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
