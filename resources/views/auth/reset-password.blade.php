@section('page-title')
    Restaurar contraseña
@endsection

<x-guest-layout>
    <main>
        <div class="contenedor__todo">
            <div class="mt-5 caja__trasera">
                <div class="h-60 w-96 caja__trasera-login">
                    {{-- <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para entrar en la página</p>
                    <button id="btn__iniciar-sesion">Iniciar Sesión</button> --}}
                </div>
                <div class="caja__trasera-register">
                    <p>Indique su nueva contraseña para acceder a su cuenta.</p>
                </div>
            </div>

            <!--Formulario de Login y registro-->
            <div class="contenedor__login-register">
                <!--Login-->
                <form method="POST" action="{{ route('user-password.update') }}">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <h2>Restaurar contraseña</h2>

                    <div class="block">
                        <x-input id="email" class="block w-full" type="email" name="email" :value="old('email', $request->email)"
                            placeholder="usuario@email.com" required autofocus autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <x-input id="password" class="block w-full" type="password" name="password" required
                            placeholder="********" autocomplete="new-password" />
                    </div>

                    <div class="mt-4">
                        <x-input id="password_confirmation" placeholder="********" class="block w-full" type="password"
                            name="password_confirmation" required autocomplete="new-password" />
                    </div>
                    <div class="text-center">
                        <a class="font-italic isai5" href="{{ route('login') }}">Iniciar sesión </a>
                    </div>
                    <button>Enviar</button>
                </form>

            </div>

        </div>
    </main>
</x-guest-layout>
