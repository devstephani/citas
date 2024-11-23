<div x-data="{ open: @entangle('showModal') }">
    <x-button type="button" wire:click="$dispatch('pdf')" class="w-full sm:w-fit gap-3">
        <x-lucide-file-text class="size-5" />
        Reportes
    </x-button>
    <x-button wire:click="toggle" class="w-full sm:w-fit gap-3">
        <x-lucide-plus class="size-5" />
        Paquete
    </x-button>

    <x-modal id="package-modal" maxWidth="md" wire:model="showModal">
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                @if ($id > 0)
                    Actualizar
                @else
                    Registrar
                @endif paquete
            </div>

            <div class="mt-4 text-sm text-gray-600">
                <article class="mb-4 flex flex-col gap-4">
                    <div class="block">
                        <x-label value="Nombre" for="name" />
                        <x-input wire:model.lazy="name" type="text" id="name" name="name" class="w-full"
                            placeholder="Ej: Combo 1" autofocus autocomplete="off" required />
                        <x-input-error for="name" class="mt-2" />
                    </div>
                    <div class="block">
                        <x-label value="Descripción" for="description" />
                        <x-textarea wire:model.lazy="description" id="description" name="description" class="w-full"
                            placeholder="Ej: Belleza" required></x-textarea>
                        <x-input-error for="description" class="mt-2" />
                    </div>
                    <div class="block">
                        <x-label value="Precio" for="price" />
                        <x-input wire:model.lazy="price" type="number" id="price" name="price" required
                            placeholder="Ej: 5" class="w-full" />
                        <x-input-error for="price" class="mt-2" />
                    </div>
                    <div class="block">
                        <x-label value="Servicios" for="service_ids" />
                        <x-select wire:model.lazy="service_ids" id="service_ids" name="service_ids[]" multiple required
                            class="w-full" no_default>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}"
                                    {{ in_array($service->id, $services->toArray()) ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error for="service_ids" class="mt-2" />
                    </div>
                    @if ($id > 0)
                        <div class="block">
                            <x-label value="Activo" for="active" />
                            <x-select wire:model.lazy="active" id="active" name="active" required class="w-full">
                                <option value="0" @selected(0 == $active)>Inactivo</option>
                                <option value="1" @selected(1 == $active)>Activo</option>
                            </x-select>
                            <x-input-error for="active" class="mt-2" />
                        </div>
                    @endif

                    <x-label value="Imágen" for="image" />

                    <x-input type="file" wire:model="image" accept=".jpg" />

                    <x-input-error for="image" class="mt-2" />
                    @if (($image && $id < 1) || ($image && $prevImg !== $image))
                        <img src="{{ $image->temporaryUrl() }}">
                    @endif
                    @if ($prevImg === $image && $id > 0)
                        <img src="{{ asset('storage/' . $image) }}">
                    @endif
                    <div wire:loading wire:target="image">
                        <p class="text-gray-600">Cargando imágen, por favor espere...</p>
                    </div>
                </article>

                @if ($id > 0)
                    <x-button wire:target="image" type="button" wire:click="update()" wire:loading.attr="disabled">
                        Actualizar
                    </x-button>
                @else
                    <x-button wire:target="image" type="button" wire:click="save()" wire:loading.attr="disabled">
                        Registrar
                    </x-button>
                @endif
            </div>
        </div>
    </x-modal>
</div>
