<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register()
    {
        return view('pages.auth.register');
    }

    public function login()
    {
        return view('pages.auth.login');
    }

    public function storeRegister(Request $request)
    {

        $validasi = Validator::make($request->only('email','password'),[
            'email' =>'required|email|unique:users,email',
            'password' => 'required|min:8'
        ],[
            'email.unique' => 'Email Sudah Di Gunakan !',
            'email.required' => 'Email Harus Di Isi !',
            'password.required' => 'Password Wajib Di Isi!',
            'password.min' => 'Password Mininal 8 Karakter'
        ]);

        if($validasi->fails()){
            return back()->with('error',$validasi->errors()->first());
        }

        try {
            $password = Hash::make($request->password);
            $user = User::create([
                'name' => 'User' . mt_rand(1111,9999),
                'email' => $request->email,
                'password' => $password
            ]);

            $user->assignRole('User');

            return back()->with('success','Success Register');
        } catch (\Exception $e) {
            return back()->with('error',$e->getMessage());
        }
    }

    public function authenticated(Request $request)
    {
        $validasi = Validator::make($request->only('email','password'),[
            'email' =>'required|email',
            'password' => 'required|min:8'
        ]);

        if($validasi->fails()){
            return back()->with('error',$validasi->errors()->first());
        }

        $user = User::where('email',$request->email)->first();

        if(!$user)
            return back()->with('error','User Not Found!');

        if(Auth::attempt(['email' => $request->email,'password' => $request->password])){
            return redirect('/');
        }

        return back()->with('error','Something Went Wrong!');
    }

    public function logout(Request $request)
    {
        try {
            if(Auth::logout()){
                $request->session()->invalidate();

                $request->session()->regenerateToken();
                return redirect()->to(route('login'))->with('success','Logout');
            }

            return back()->with('error','Something Went Wrong!');
        } catch (\Exception $e) {
            return back()->with('error',$e->getMessage());
        }
    }

}
