<div class="py-4 px-4 sm:p-4">
    <label for="table-search" class="sr-only">Buscador</label>
    <div class="w-full relative">
        <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
            <x-lucide-search class="size-3.5" />
        </div>

        <x-input wire:ignore.self wire:model.live="query" type="text" placeholder="Buscar registros"
            class="ps-9 w-full sm:w-fit" autocomplete="off" wire:click="dispatch('clear')" />
    </div>
</div>
