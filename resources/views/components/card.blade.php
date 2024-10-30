@props(['title' => '', 'value' => null])

<div class="bg-white p-4 border border-gray-300 rounded-md inline-flex flex-col gap-3">
    <h5 class="text-xl font-semibold">{{ $title }}</h5>
    <p class="text-3xl text-neutral-600">
        {{ gettype($value) === 'integer' ? number_format($value, 0, ',', '.') : $value }}
    </p>
</div>
