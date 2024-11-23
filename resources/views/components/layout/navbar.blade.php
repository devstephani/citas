@if (is_null(Auth::user()) || Auth::user()->hasRole('client'))
    <div @class([
        'eorik-nav-style fixed-top z-10',
        'bg-black' => Route::is('appointments'),
    ])>
        <div class="navbar-area">
            <!-- Menu For Mobile Device -->
            <div class="mobile-nav">
                <a href="{{ route('dashboard') }}" class="logo">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo">
                </a>
            </div>
            <!-- Menu For Desktop Device -->
            <div class="main-nav">
                <nav class="navbar navbar-expand-md navbar-light">
                    <div class="container">
                        <a class="navbar-brand" href="{{ route('home') }}">
                            <img src="{{ asset('img/logo.jpg') }}" width="60" alt="Logo">
                        </a>

                        <div class="navbar-collapse mean-menu" id="navbarSupportedContent" style="display: block;">
                            <ul class="navbar-nav m-auto">

                                @auth
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard') }}" class="nav-link">
                                            Inicio
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('services') }}" class="nav-link">
                                            Servicios
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('packages') }}" class="nav-link">
                                            Paquetes
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('blog') }}" class="nav-link">
                                            Blog
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('virtual') }}" class="nav-link">
                                            Probador virtual
                                        </a>
                                    </li>
                                @endauth
                                @guest

                                    <li class="nav-item">
                                        <a href="{{ route('login') }}" class="nav-link active">
                                            Iniciar sesión
                                        </a>
                                    </li>
                                @endguest
                            </ul>

                            @auth
                                <div class="others-option">
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <span class="inline-flex rounded-md">
                                                <button type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                    {{ Auth::user()->name }}

                                                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </x-slot>

                                        <x-slot name="content">
                                            <!-- Account Management -->
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                {{ __('Cuenta') }}
                                            </div>

                                            <x-dropdown-link href="{{ route('profile.show') }}">
                                                {{ __('Perfil') }}
                                            </x-dropdown-link>

                                            <div class="border-t border-gray-200"></div>

                                            <!-- Authentication -->
                                            <form method="POST" action="{{ route('logout') }}" x-data>
                                                @csrf

                                                <x-dropdown-link href="{{ route('logout') }}"
                                                    @click.prevent="$root.submit();">
                                                    {{ __('Cerrar sesión') }}
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            @endauth
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
@endif
