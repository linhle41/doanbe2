<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ForgetPasswordController extends Controller
{
    //
       //lấy mật khẩu
       public function submitForgetPasswordForm(Request $request)
       {
           // Request $request
           $request->validate([
               'name' => 'required',
               'email' => 'required|email|exists:users',
           ]);
           $name = $request->only('name');
           $email =  $request->only('email');
           $token = '456789';
           $user = User::where('email', $email)->where('name', $name)->first();
        //    dd($user);die();
           if ($user != null) {
               //chuyển từ array về string
               $user->name = $name['name'];
               $user->email = $email['email'];
               $hashedPassword = Hash::make($token);
               // lưu mật khẩu vào trường email trong model User
               $user->password = $hashedPassword;
               $user->save();
               if($user->role == '1')
               {
                   $to_email = $email['email'];
                   $username = $name['name'];
                   Mail::send('emails.resetpassword',compact('username'),function($email) use($username,$to_email) {
                       $email->subject('Reset Password');
                       $email->to($to_email,$username);
                   });
               }
           }
           return view('auth.login')->with('message', 'We have e-mailed your password reset link!');
       }
       
       public function forget_password()
       {
           return view('auth.forgetPassword');
       }
}
