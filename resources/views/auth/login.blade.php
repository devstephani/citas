@section('page-title')
    Inicio de sesión
@endsection

<x-guest-layout>
    <main>
        @error('inactive')
            <div class="mb-12 w-full">
                <p
                    class="z-50 block w-fit py-1.5 px-4 shadow-lg rounded-sm border border-neutral-400 mx-auto text-red-600 bg-white">
                    {{ $message }}

                </p>
            </div>
        @enderror
        <div class="contenedor__todo">
            <div class="mt-5 caja__trasera">
                <div class="caja__trasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para entrar en la página</p>
                    <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                </div>
                <div class="caja__trasera-register">
                    <h3>¿Aún no tienes una cuenta?</h3>
                    <p>Regístrate para que puedas iniciar sesión</p>
                    <a href="{{ route('register') }}">
                        <button id="btn__registrarse">Regístrarse</button>
                    </a>
                </div>
            </div>

            <!--Formulario de Login y registro-->
            <div class="contenedor__login-register">
                <!--Login-->
                <form method="POST" action="{{ route('login') }}" class="formulario__login">
                    @csrf
                    <h2>Iniciar Sesión</h2>
                    <x-input type="email" id="email" name="email" placeholder="Correo Electrónico" required
                        :value="old('email')" />
                    <x-input-error for="email" class="mt-2" />
                    <div x-data="{ type: 'password' }" class="block mt-1 w-full relative">
                        <x-input type="password" id="password" name="password" placeholder="Contraseña" required
                            autocomplete="new-password" />
                        <x-input-error for="password" class="mt-2" />
                    </div>
                    <div class="text-center">
                        <a class="font-italic isai5" href="{{ route('password.request') }}">Olvidé mi contraseña </a>
                    </div>
                    <button>Entrar</button>
                </form>
            </div>

        </div>
    </main>
</x-guest-layout>
