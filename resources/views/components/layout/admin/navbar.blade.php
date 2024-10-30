<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-300">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button @click="open = true" aria-controls="logo-sidebar" type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>
                <a href="{{ route('dashboard') }}" class="flex ms-2 md:me-24">
                    <img src="{{ asset('img/logo.jpg') }}" class="h-8 me-3" alt="FlowBite Logo" />
                    <span class="self-center text-base sm:text-xl font-semibold whitespace-nowrap ">Browslashes
                        Stefy</span>
                </a>
            </div>
            <div x-data="{ dropdown: false }" class="flex items-center">
                <div class="flex flex-col items-center ms-3">
                    <div @click.outside="dropdown = false">
                        <button @click="dropdown = ! dropdown" type="button"
                            class="flex text-sm rounded-full focus:ring-2 focus:ring-neutral-700" aria-expanded="false"
                            data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>
                            <x-lucide-circle-user-round class="size-8" />
                        </button>
                    </div>
                    <div x-show="dropdown" x-transition
                        class="absolute w-48 top-8 right-3 z-50 my-4 text-base list-none bg-white divide-y divide-gray-100 shadow-lg border !border-neutral-400 rounded-sm"
                        id="dropdown-user">
                        <div class="px-4 py-3" role="none">
                            <p class="text-sm text-gray-900 " role="none">
                                {{ auth()->user()->name }}
                            </p>
                        </div>
                        <ul class="py-1" role="none">
                            <li>
                                <a href="{{ route('profile.show') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-500 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem">Perfil</a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <a href="{{ route('logout') }}" @click.prevent="$root.submit();"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-500 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Cerrar sesión</a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
