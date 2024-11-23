<?php

namespace App\Enum\Payment;

enum TypeEnum: string
{
    case Contado = 'FULL';
    case PagoMóvil = 'MOBILE';
    case Paypal = 'PAYPAL';
}
