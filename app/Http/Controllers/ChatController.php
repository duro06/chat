<?php

namespace App\Http\Controllers;

use App\User;
use App\Events\ChatEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
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
    public function chat(){
        return view('chat');

    }
    public function send(Request $request){
        //mencari user dengan authentifikasi berdasarkan ID, masukkan ke dalam variable $user
        $user = User::find(Auth::id());
        // simpan variable $request ke session
        $this->saveToSession($request);
        // kirimkan event chat ke user
        event(new ChatEvent($request->message, $user));
        // return $request->all(); 
    }
    public function saveToSession(Request $request){
        // fungsi untuk menyimpan di session chat, yang disimpan adalah data chat yang ada di app.vue
        session()->put('chat', $request->chat);
    
    }
    public function getOldMessage(){
        // mnegembalikan apa yang ada di session chat
        // route nya ada di web
        return session('chat');
    }

    public function deleteSession()
    {
        session()->forget('chat');
    }
}
