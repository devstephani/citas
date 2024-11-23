<?php

namespace App\Models;

use App\Enum\Service\TypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'image',
        'active',
        'price',
        'type',
        'employee_id',
        'user_id'
    ];

    protected $casts = [
        'type' => TypeEnum::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id', 'employee');
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
