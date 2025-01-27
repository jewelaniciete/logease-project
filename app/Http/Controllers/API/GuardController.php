<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Key;
use App\Models\Guard;
use App\Models\Barrow;
use App\Models\Retrun;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GuardController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $credentials = $request->only('email', 'password');

        if (auth()->guard('guard')->attempt($credentials)) {
            $guard = Guard::where('email', $request->email)->first();
            return response()->json(['message' => 'Login successful.', 'guard' => $guard]);
        }

        return response()->json(['message' => 'Invalid email or password.'], 401);
    }

    public function keys(){
        $keys = Key::where('status', '!=', 'borrowed')->orWhereNull('status')->get();
        return response()->json($keys);
    }

    public function borrowed(){
        $keys = Key::where('status', 'borrowed')->get();
        return response()->json($keys);
    }

    public function scan(Request $request){
        $validator = Validator::make($request->all(), [
            'key' => 'required|exists:keys,id',
            'barcode' => 'required|exists:teachers,code',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $keys = Key::where('status', '!=', 'borrowed')->orWhereNull('status')->get();

        $key_id = Key::find($request->key)->id;
        $teacher = Teacher::where('code', $request->barcode)->first();
        $teacher_id = $teacher->id;

        $borrow = new Barrow;
        $borrow->key_id = $key_id;
        $borrow->teacher_id = $teacher_id;
        $borrow->date = Carbon::now();
        $borrow->save();

        Key::where('id', $key_id)->update(['status' => 'borrowed']);

        return response()->json(['message' => 'Scan successful.']);
    }

    public function borrow_list(){
        $models = Barrow::with(['key', 'teacher'])->get();

        return response()->json($models);
    }

    // public function return($id)
    // {
    //     $barrow = Barrow::find($id);

    //     if ($barrow) {
    //         // Create a new return entry
    //         $return = new Retrun;
    //         $return->key_id = $barrow->key_id;
    //         $return->teacher_id = $barrow->teacher_id;
    //         $return->date = Carbon::now();
    //         $return->save();

    //         // Update the status of the key table
    //         $key = Key::find($barrow->key_id);
    //         if ($key) {
    //             $key->status = 'returned'; // Update the status to 'returned' or any appropriate value
    //             $key->save();
    //         }

    //         // Update the status of the barrow table
    //         $barrow->status = 'returned'; // Update the status to 'returned' or any appropriate value
    //         $barrow->save();

    //         return response()->json(['message' => 'Return successful.']);
    //     }

    //     return response()->json(['message' => 'Return failed.'], 400);
    // }

    public function return(Request $request){
        $validator = Validator::make($request->all(), [
            'key' => 'required|exists:keys,id',
            'barcode' => 'required|exists:teachers,code',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $key_id = $request->key;
        $teacher = Teacher::where('code', $request->barcode)->first();
        $teacher_id = $teacher->id;


        $item = Barrow::where('key_id', $key_id)->where('teacher_id', $teacher_id)->first();

        if (!$item) {
            return response()->json(['message' => 'Record not found.'], 404);
        }

        $return = new Retrun;
        $return->key_id = $key_id;
        $return->teacher_id = $teacher_id;
        $return->date = Carbon::now();
        $return->save();

        Key::where('id', $key_id)->update(['status' => 'returned']);

        // Update the status of the barrow table
        $item->status = 'returned';   // Update the status to 'returned' or any appropriate value
        $item->save();

        return response()->json(['message' => 'Return successful.']);
    }

    public function return_list(){
        $models = Retrun::with(['key', 'teacher'])->get();

        return response()->json($models);
    }

    public function key_list(){
        $models = Key::all();
        return response()->json($models);
    }

    public function logout(Request $request){
        auth()->guard('guard')->logout();
        return response()->json(['message' => 'Logged out.']);
    }
}
