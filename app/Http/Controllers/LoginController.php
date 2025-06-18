<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }
    //melakukan autentikasi login
    public function autentikasi(Request $request)
    {
        $credential=$request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ],[
            'email.required'=>'Email Tidak Boleh Kosong!',
            'password.required'=>'Password Tidak Boleh Kosong!'

        ]);
        if(Auth::attempt($credential)){
            $request->session()->regenerate();
            return redirect()->intended('/dasboard');
        }
         return back()->withErrors([

            'email' => 'Autentikasi Gagal!',

        ])->onlyInput('email');

    }
    public function registrasi()
    {
        return view('login.registrasi');
    }
    public function store(Request $request)
    {
        $validatedata=$request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required'
        ]);
        User::create($validatedata);
        return redirect()->route('login.index');
    }
    public function keluar(){
        Auth::logout();
        session()->invalidate();
        session()->regeneratetoken();
        return redirect()->route('login');
    }

}
