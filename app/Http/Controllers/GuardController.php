<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Key;
use App\Models\Barrow;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuardController extends Controller
{
    public function index(){
        return view('LoginPage');
    }

    public function scan(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $keys = Key::where('status', '!=', 'borrowed')->orWhereNull('status')->get();

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (auth()->guard('guard')->attempt($credentials)) {
            return view('ScanPage', compact('keys'));
        }

        return redirect()->back()->with('error', 'Invalid email or password.');
    }

    public function borrow(Request $request){
        $key_id = Key::find($request->key)->id;
        $teacher_id = Teacher::where('code', $request->barcode)->first()->id;

        if (!$teacher_id) {
            return response()->json([
                'error' => 'Invalid teacher barcode. Please scan registered teacher barcode.',
            ]);
        }

        $borrow = new Barrow;
        $borrow->key_id = $key_id;
        $borrow->teacher_id = $teacher_id;
        $borrow->date = Carbon::now();
        $borrow->save();

        Key::where('id', $key_id)->update(['status' => 'borrowed']);

        return response()->json([
            'success' => 'Key borrowed successfully.',
        ]);
    }

    public function logout(){
        auth()->guard('guard')->logout();

        return redirect()->route('guard');
    }
}
