<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatBoxController extends Controller
{
    public function show(){

      $login_user = Auth::user();
        $users= User::where('id', '!=',  $login_user->id)->orderBy('name','ASC')->get();
        $usernames = $users->pluck('name');
        return view("chatbox.chat", ["username"=> $usernames]);  
    }
}
