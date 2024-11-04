<x-app-layout>
    @if (is_null(Auth::user()) || Auth::user()->hasRole('client'))
        <x-home.slider />
        <x-home.check />
        <x-home.info />
        @if (count($personal) > 0)
            <x-home.personal :personal="$personal" />
        @endif
        @if (count($packages) > 0)
            <x-home.services :packages="$packages" />
        @endif
        <x-home.mackup />
        <x-home.testimonials />
    @endif
</x-app-layout>
