<div class="p-4 bg-white dark:bg-gray-900">
    <label for="table-search" class="sr-only">Buscador</label>
    <div class="relative mt-1">
        <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
            <x-lucide-search class="size-3.5" />
        </div>

        <x-input wire:ignore.self wire:model.live="query" type="text" placeholder="Buscar registros" class="ps-9"
            autocomplete="off" wire:click="dispatch('clear')" />
    </div>
</div>
