@props(['disabled' => false, 'no_default' => false])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
]) !!}>
    @if (!$no_default)
        <option value="" selected>Seleccione una opción</option>
    @endif
    {{ $slot }}
</select>
