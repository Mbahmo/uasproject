<?php

namespace App\Http\Controllers;

use App\User;
use \Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
      $user = User::find(Auth::user()->id);
    return view('home', compact('user'));
    }
    public function upload(Request $request){
        $validator = Validator::make($request->all(), [
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->passes()) {
            $input = $request->all();
            $input['gambar'] = time().'.'.$request->gambar->getClientOriginalExtension();
            $request->gambar->move(public_path('images'), $input['gambar']);
            $user = User::find($input['id']);
            $imagelama = (public_path('images').'/'.$user->image);
            // dd($imagelama);
            unlink($imagelama);
            $user->image  = $input['gambar'];
            $user->save();
        }
        return redirect('/home');
    }
}
