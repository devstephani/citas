<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Snowfire\Beautymail\Beautymail;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request)
    {
        $user = User::where('email',  '=', $request->correo)->first();
        

        if (!empty($user)) {
            try {
                Password::sendResetLink(['email' => $request->correo]);
                $mail = new ResetPassword($user);
                Mail::to($user->email)->send($mail);

                return redirect()->back()->with('success', 'Se envió el código de recuperación al correo adjuntado.');
            } catch (\Throwable $th) {
                return redirect()->back()->with('success', 'Se envió el código de recuperación al correo adjuntado.');
            }
        }

        return redirect()->back()->withErrors([
            'email' => 'Usuario no encontrado.'
        ]);
    }
}
