<div class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50" />
<div class="fixed inset-0 transform transition-all" x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
</div>

<div {!! $attributes->merge([
    'class' =>
        'mb-6 bg-white rounded-lg shadow-xl transform transition-all sm:w-full sm:max-w-md sm:mx-auto overflow-y-auto max-h-screen',
]) !!} x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
    {{ $slot }}
</div>
</div>
