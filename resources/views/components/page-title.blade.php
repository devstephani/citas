@props(['title', 'subtitle'])

<div class="page-title-area">
    <div class="container">
        <div class="page-title-content">
            <h2>{{ $title }}</h2>
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}">
                        Inicio
                    </a>
                </li>
                @if (isset($subtitle))
                    <li>{{ $subtitle }}</li>
                @endif
            </ul>
        </div>
    </div>
</div>
