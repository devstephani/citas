<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'image', 'active', 'price', 'type', 'employee_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id', 'employee');
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class);
    }
}
