<div class="flex flex-col sm:flex-row justify-between mb-4">
    <div class="flex justify-start gap-3 font-bold text-xl">
        <p>{{ ucfirst($startsAt->translatedFormat('F')) }}</p>
        <p>{{ $startsAt->translatedFormat('Y') }}</p>
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
