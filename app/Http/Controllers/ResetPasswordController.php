<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request) {
        $user = User::where('email', $request->email)->first();

        if (!empty($user)) {
            try {
                $mail = new ResetPassword($user);
                Mail::to($user->email)->send($mail);

                return redirect()->back();
            } catch (\Throwable $th) {}        
        } 
        
        return redirect()->back()->withErrors([
            'email' => 'Usuario no encontrado.'
        ]);
    }
}
