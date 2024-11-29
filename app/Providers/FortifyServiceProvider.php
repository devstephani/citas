<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\Attendance;
use App\Models\Binnacle;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // 
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where(['email' => $request->email])->first();

            if ($user && Hash::check($request->password, $user->password)) {
                if ($user->hasRole('employee')) {
                    $today = now()->format('Y-m-d');
                    $attendanceExists = Attendance::where('employee_id', $user->employee->id)
                        ->whereDate('created_at', $today)
                        ->where('type', 1)
                        ->exists();

                    if (!$attendanceExists) {
                        Attendance::create([
                            'employee_id' => $user->employee->id,
                            'type' => 1
                        ]);
                    }
                }

                Binnacle::create([
                    'user_id' => $user->id,
                    'status' => 'success',
                    'message' => "Inició sesión"
                ]);

                return $user;
            }
        });

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
