<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuardController extends Controller
{
    public function index(){
        return view('LoginPage');
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (auth()->guard('guard')->attempt($credentials)) {
            return redirect()->away('https://www.google.com');
        }

        return redirect()->back()->with('error', 'Invalid email or password.');
    }
}
