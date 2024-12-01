<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'photo',
        'user_id'
    ];

    public function get_image()
    {
        $path = $this->photo;

        $src = in_array($path, ['jose.jpg', 'stefy.jpg', 'alexandra.jpg'])
            ? asset('img/presentacion/' . $this->photo)
            : asset('storage/' . $this->photo);

        return $src;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'employee_service');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
