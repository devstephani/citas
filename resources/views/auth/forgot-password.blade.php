@section('page-title')
    Recuperar contraseña
@endsection

<x-guest-layout>
    <main>
        <div class="contenedor__todo">
            <div class="mt-5 caja__trasera">
                <div class="h-36 w-96 caja__trasera-login">
                    {{-- <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para entrar en la página</p>
                    <button id="btn__iniciar-sesion">Iniciar Sesión</button> --}}
                </div>
                <div class="caja__trasera-register">
                    <p>Indique su correo electrónico para recuperar su contraseña.</p>
                </div>
            </div>

            <!--Formulario de Login y registro-->
            <div class="contenedor__login-register">
                <!--Login-->
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <h2>Recuperar contraseña</h2>
                    <input type="email" style="display:none">

                    @if (session()->has('success'))
                        <p class="text-green-500">{{ session('success') }}</p>
                    @endif

                    <x-label for="correo" value="{{ __('Email') }}" />
                    <x-input id="correo" placeholder="Ej: correo@email.com" class="block mt-1 w-full" type="email"
                        name="correo" :value="old('correo')" required autofocus />
                    <x-input-error for="email" class="mt-2" />

                    <div class="text-center">
                        <a class="font-italic isai5" href="{{ route('login') }}">Iniciar sesión </a>
                    </div>
                    <button>Enviar</button>
                </form>

            </div>

        </div>
    </main>
</x-guest-layout>

{{-- 
<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}
