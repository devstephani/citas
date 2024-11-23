<?php

namespace App\Models;

use App\Enum\Payment\CurrencyEnum;
use App\Enum\Payment\TypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'type',
        'payed',
        'currency',
        'ref'
    ];
    protected $casts = [
        'currency' => CurrencyEnum::class,
        'type' => TypeEnum::class
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
