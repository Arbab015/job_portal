<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;

class ForgetPasswordController extends Controller

{
    public function showForgotPasswordPage()
    {   
        
            return view('forgot_password'); 
        }
    
     public function sendResetEmailLink(Request $request){
              $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    } 
    }
