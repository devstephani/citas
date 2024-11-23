<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'picked_date',
        'status',
        'user_id',
        'service_id',
        'package_id',
        'registered_local'
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->registered_local = Auth::user()->hasAnyRole(['admin', 'employee']);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
