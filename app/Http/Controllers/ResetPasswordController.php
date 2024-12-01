<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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

                $beautymail = app()->make(Beautymail::class);
                $beautymail->send('');

                return redirect()->back()->with('success', 'Se envió el código de recuperación al correo adjuntado.');
            } catch (\Throwable $th) {
                if ($th->getMessage() === 'View [] not found.') {
                    return redirect()->back()->with('success', 'Se envió el código de recuperación al correo adjuntado.');
                }
            }
        }

        return redirect()->back()->withErrors([
            'email' => 'Usuario no encontrado.'
        ]);
    }
}
