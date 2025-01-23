<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Key;
use App\Models\Barrow;
use App\Models\Retrun;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuardController extends Controller
{
    public function index(){
        return view('LoginPage');
    }

    public function scan(Request $request)
    {
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
            // Pass credentials to the view (but do not expose sensitive information like passwords in production)
            return view('ScanPage', compact('keys', 'credentials'));
        }

        return redirect()->back()->with('error', 'Invalid email or password.');
    }

    public function borrow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required|exists:keys,id',
            'barcode' => 'required|exists:teachers,code',
        ]);

        if ($validator->fails()) {
            // Retrieve credentials from session (if available)
            $credentials = $request->session()->get('credentials');

            if ($credentials) {
                // Pass the credentials to the scan method
                return $this->scan(new Request(array_merge($request->all(), $credentials)))
                            ->withErrors($validator);
            }

            // If no credentials are found, return an error response
            return redirect()->back()->withErrors($validator);
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

        return $this->borrow_list();
    }

    public function return(Request $request, $id)
    {
        $barrow = Barrow::find($id);

        if ($barrow) {
            // Create a new return entry
            $return = new Retrun;
            $return->key_id = $barrow->key_id;
            $return->teacher_id = $barrow->teacher_id;
            $return->date = Carbon::now();
            $return->save();

            // Update the status of the key table
            $key = Key::find($barrow->key_id);
            if ($key) {
                $key->status = 'returned'; // Update the status to 'returned' or any appropriate value
                $key->save();
            }

            // Update the status of the barrow table
            $barrow->status = 'returned'; // Update the status to 'returned' or any appropriate value
            $barrow->save();

            return $this->return_list();
        }

        return redirect()->back()->with('error', 'Item not found');

    }

    public function borrow_list(){
        $models = Barrow::with(['key', 'teacher'])->get();

        return view('BorrowListPage', compact('models'));
    }

    public function return_list(){
        $models = Retrun::with(['key', 'teacher'])->get();

        return view('ReturnListPage', compact('models'));
    }

    public function key_list(){
        $models = Key::all();

        return view('KeyListPage', compact('models'));
    }

    public function logout(){
        auth()->guard('guard')->logout();

        return redirect()->route('guard');
    }

    public function back(Request $request){
        $credentials = $request->session()->get('credentials');

        if ($credentials) {
            // Pass the credentials to the scan method
            return $this->scan(new Request(array_merge($request->all(), $credentials)));
        }
    }
}
