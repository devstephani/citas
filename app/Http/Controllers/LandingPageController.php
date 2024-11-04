<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $packages = Package::where('active', '=', 1)
            ->paginate(5);
        return view('dashboard', [
            'packages' => $packages
        ]);
    }
}
