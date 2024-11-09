<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Employee;
use App\Models\Package;
use App\Models\Post;

class LandingPageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $packages = Package::where('active', '=', 1)
            ->paginate(5);
        $personal = Employee::with('user')
            ->whereHas('user', function ($q) {
                $q->where('active', '=', 1);
            })
            ->get();
        $posts = Post::where('active',  1)
            ->orderByDesc('created_at')
            ->paginate(10);

        $comments = Comment::where('active', 1)
            ->inRandomOrder()
            ->take(10)
            ->get();

        $comments = count($comments) > 3 ? $comments : [];

        return view('dashboard', [
            'packages' => $packages,
            'personal' => $personal,
            'posts' => $posts,
            'comments' => $comments
        ]);
    }
}
