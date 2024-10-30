<x-app-layout>
    @if(is_null(Auth::user()) || Auth::user()->hasRole('client'))
        <x-home.slider />
        <x-home.check />
        <x-home.info />
        <x-home.personal />
        <x-home.services />
        <x-home.mackup />
        <x-home.city-view-slider />
        <x-home.rooms />
        <x-home.testimonials />
    @endif
</x-app-layout>
