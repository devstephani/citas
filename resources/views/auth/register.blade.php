@section('page-title')
    Registro
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
                    <h3>¿Ya tienes una cuenta?</h3>
                    <a href="{{ route('login') }}">
                        <button id="btn__registrarse">Iniciar sesión</button>
                    </a>
                </div>
            </div>

            <!--Formulario de Login y registro-->
            <div class="contenedor__login-register">
                <!--Register-->
                <form method="POST" action="{{ route('register') }}" class="formulario__login">
                    @csrf
                    <h2>Regístrarse</h2>
                    <input required type="text" placeholder="Nombre" name="name" :value="old('name')">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                    <input required type="number" placeholder="Teléfono" name="phone" :value="old('phone')">
                    @error('phone')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                    <input required type="email" placeholder="Correo Electronico" name="email"
                        :value="old('email')">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                    <input required type="password" placeholder="Contraseña" name="password"
                        autocomplete="new-password">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                    <input id="password_confirmation" class="block mt-1 w-full" type="password"
                        placeholder="Confirmar contraseña" name="password_confirmation" required
                        autocomplete="new-password" />
                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                    <button>Regístrarse</button>
                </form>
            </div>

        </div>
    </main>
</x-guest-layout>
