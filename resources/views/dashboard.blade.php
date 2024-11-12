@section('page-title')
    Inicio
@endsection

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
        @if (count($posts) > 0)
            <x-home.mackup :posts="$posts" />
        @endif
        @if (count($comments) > 0)
            <x-home.testimonials :comments="$comments" />
        @endif
    @endif
</x-app-layout>
