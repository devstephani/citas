@props(['disabled' => false])

@if ($attributes['type'] === 'password')
    <div x-data="{ eye: false }" class="relative">
        <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
            'class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
        ]) !!} x-bind:type="eye ? 'text' : 'password'" />

        <div class="absolute top-3 right-3 cursor-pointer" @click="eye = !eye">
            <x-lucide-eye x-show="eye" class="size-4" />
            <x-lucide-eye-off x-show="!eye" class="size-4" />
        </div>
    </div>
@else
    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
        'class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
    ]) !!}>
@endif
