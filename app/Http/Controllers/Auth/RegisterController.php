<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

    class RegisterController extends Controller
    { 
        public function showForm()
        {
            return view('auth.register'); 
        }


        public function register(Request $request)
        {
       try{
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|max:16|confirmed', 
            ]);
            
             User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
             return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
        }catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
        }

    
    }