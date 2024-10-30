<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/meanmenu.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nice-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/odometer.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/date-picker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/beautiful-fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dark.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <x-layout.preloader />
    <x-layout.navbar />
    <x-layout.sidebar-modal />

    @if(is_null(Auth::user()) || Auth::user()->hasRole('client'))
        {{ $slot }}
    @endif

    @role('admin')
        <div x-data="{ open: false, desktop: window.innerWidth >= 640 }" x-init="window.addEventListener('resize', () => desktop = window.innerWidth >= 640)">
            <x-layout.admin.navbar />
            <x-layout.admin.sidebar />

            <div class="pb-4 mt-16 sm:ml-64 bg-neutral-100 min-h-[calc(100dvh-6.8dvh)]">
                {{ $slot }}
            </div>
        </div>
    @endrole

    @if(is_null(Auth::user()) || Auth::user()->hasRole('client'))
        <x-home.footer />

        <div class="go-top">
            <i class='bx bx-chevrons-up bx-fade-up'></i>
            <i class='bx bx-chevrons-up bx-fade-up'></i>
        </div>
    @endif

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/meanmenu.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <script src="{{ asset('js/nice-select.min.js') }}"></script>
    <script src="{{ asset('js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/jquery.mixitup.min.js') }}"></script>
    <script src="{{ asset('js/appear.min.js') }}"></script>
    <script src="{{ asset('js/odometer.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/ofi.min.js') }}"></script>
    <script src="{{ asset('js/jarallax.min.js') }}"></script>
    <script src="{{ asset('js/form-validator.min.js') }}"></script>
    <script src="{{ asset('js/contact-form-script.js') }}"></script>
    <script src="{{ asset('js/ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('fullcalendar/index.global.min.js') }}"></script>
    <script src="{{ asset('fullcalendar/es.global.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/pages/index.js') }}"></script>

    <script>
        function alertaSW(Mensaje, tipo) {
            Swal.fire({
                position: "top-end",
                icon: tipo,
                title: Mensaje,
                showConfirmButton: false,
                timer: 2500,
                toast: true

            });
        }

        function delete_alert(id) {
            Swal.fire({
                title: 'Un registro será borrado',
                text: '¿Desea eliminar el registro permanentemente?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#dc2626",
                cancelButtonColor: "#a3a3a3",
                confirmButtonText: 'Continuar',
                cancelButtonText: 'Cancelar'
            }).then(function(result) {
                if (result.value) {
                    Livewire.dispatch('delete', {
                        record: id
                    })
                    swal.close()
                }
            })
        }
    </script>
    @stack('modals')
    @livewireScripts
    @include('popper::assets')
    @livewireChartsScripts
</body>

</html>
