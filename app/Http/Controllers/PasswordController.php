<?php
    namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Password;

class PasswordController extends Controller
{
     public function showForgetPasswordPage()
        {
            return view('forgetpassword'); 
        }
    
     public function sendResetEmailLink(Request $request){
       
            $request->validate(['email' => 'required|email']);

            $status = Password::sendResetLink($request -> only('email'));

            return $status == Password::RESET_LINK_SENT
                        ? back()->with('status', __('A new password reset link has been sent to your email address!'))
                        : back()->withErrors(['email' => __('We can\'t find a user with that email address.')]);
        
        return $status === Password::RESET_LINK_SENT ? response()->json([
            'message'=> __($status)
        ], 200) : response().json([
            'message'=> __($status)
        ], 400);
     
    
    }
}