@use(Carbon\Carbon)

@extends('beautymail::templates.minty')

@section('content')

    @include('beautymail::templates.minty.contentStart')
    <tr>
        <td class="title">
            Un cordial saludo, {{ $appointment->user->name }}.
        </td>
    </tr>
    <tr>
        <td width="100%" height="10"></td>
    </tr>
    <tr>
        <td class="paragraph">
            Hemos confirmado el pago de su cita del día
            {{ Carbon::createFromFormat('Y-m-d h:i:s', $appointment->picked_date)->format('d-m-Y h:i a') }} y se ha dado por
            concluido <b>
                {{ $appointment->package ? "el paquete {$appointment->package->name}" : "la cita {$appointment->service->name}" }}
            </b> {{ $appointment->package ? 'solicitado' : 'solicitada' }}.
        </td>
    </tr>
    <tr>
        <td width="100%" height="25"></td>
    </tr>
    <tr>
        <td class="paragraph">
            Esperamos haya disfrutado de nuestros servicios y hayan sido de su agrado.
        </td>
    </tr>
    <tr>
        <td class="title">
            Atte: {{ env('APP_NAME') }}
        </td>
    </tr>
    <tr>
        <td width="100%" height="25"></td>
    </tr>
    <tr>
        <td width="100%" height="25"></td>
    </tr>
    @include('beautymail::templates.minty.contentEnd')

@stop
