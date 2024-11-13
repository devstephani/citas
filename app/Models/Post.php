<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'active',
        'image',
        'description',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function get_reactions()
    {
        $reactions = $this->reactions;
        $likes = 0;
        $dislikes = 0;

        foreach ($reactions as $reaction) {
            $reaction->rate ? $likes++ : $dislikes++;
        }
        return [$likes, $dislikes];
    }
}
