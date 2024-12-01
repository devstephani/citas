@extends('beautymail::templates.minty')

@section('content')

    @include('beautymail::templates.minty.contentStart')
    <tr>
        <td class="title">
            Un cordial saludo, {{ $user }}.
        </td>
    </tr>
    <tr>
        <td width="100%" height="10"></td>
    </tr>
    <tr>
        <td class="paragraph">
            Hemos enviado este correo para que pueda recuperar su cuenta en nuestros servicios. A continuación se encuentra
            el enlace para actualizar la contraseña:
        </td>
    </tr>
    <tr>
        <td width="100%" height="25"></td>
    </tr>
    <tr>
        <td class="paragraph">
            <a href="{{ url('password/reset', $token) }}?email={{ urlencode($email) }}">Restablecer mi contraseña</a>
        </td>
    </tr>
    <tr>
        <td width="100%" height="25"></td>
    </tr>
    <tr>
        <td class="title">
            Atte: {{ env('APP_NAME') }}
        </td>
    </tr>
    <tr>
        <td width="100%" height="25"></td>
    </tr>
    @include('beautymail::templates.minty.contentEnd')

@stop
