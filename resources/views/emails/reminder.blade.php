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
            El motivo de este correo es para darle un recordatorio de la cita solicitada el día
            {{ $appointment->created_at->format('d-m-Y h:i a') }} para
            <b>
                {{ $appointment->package ? "el paquete {$appointment->package->name}" : "la cita {$appointment->service->name}" }}
            </b>
            para el día
            {{ Carbon::createFromFormat('Y-m-d H:i:s', $appointment->picked_date)->format('d-m-Y h:i a') }}
        </td>
    </tr>
    <tr>
        <td width="100%" height="25"></td>
    </tr>
    <tr>
        <td class="paragraph">
            Sin más que agregar lo esperamos para la fecha pautada.
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
