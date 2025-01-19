<div class="grid grid-cols-1 sm:grid-cols-2 mb-4">
    <div class="flex justify-center gap-3">
        <p class="text-4xl font-extrabold">{{ ucfirst($startsAt->translatedFormat('F')) }}</p>
        <p class="text-4xl font-extrabold">{{ $startsAt->translatedFormat('Y') }}</p>
    </div>
    <div class="flex gap-3  justify-end">
        <x-button wire:click="goToPreviousMonth">
            Mes anterior
        </x-button>
        <x-button wire:click="goToCurrentMonth">
            Mes actual
        </x-button>
        <x-button wire:click="goToNextMonth">
            Mes siguiente
        </x-button>
    </div>
</div>
