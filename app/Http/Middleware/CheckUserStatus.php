<?php

namespace App\Http\Middleware;

use App\Models\Attendance;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->active === 0) {

                if (Auth::check()) {
                    Auth::guard('web')->logout();
                }

                return redirect()->route('login')->withErrors(['inactive' => 'Su cuenta se encuentra inactiva.']);
            }

            if ($request->routeIs('logout')) {
                $employee = Auth::user()->employee->id;
                $today = now()->format('Y-m-d');
                $attendanceExists = Attendance::where('employee_id', $employee)
                    ->whereDate('created_at', $today)
                    ->where('type', 0)
                    ->exists();

                if (!$attendanceExists) {
                    Attendance::create([
                        'employee_id' => $employee,
                        'type' => 0
                    ]);
                }
            }
        }

        return $next($request);
    }
}
