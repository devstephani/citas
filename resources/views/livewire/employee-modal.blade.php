<div x-data="{ open: @entangle('showModal') }">
    <x-button wire:click="toggle" class="gap-3">
        <x-lucide-plus class="size-5" />
        Empleado
    </x-button>

    <x-modal id="employee-modal" maxWidth="md" wire:model="showModal">
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                @if ($id > 0)
                    Actualizar
                @else
                    Registrar
                @endif empleado
            </div>

            <div class="mt-4 text-sm text-gray-600">
                <article class="mb-4 flex flex-col gap-4">
                    <div class="block">
                        <x-label value="Nombre" for="name" />
                        <x-input wire:model.lazy="name" type="text" id="name" name="name" class="w-full"
                            autofocus autocomplete="off" required />
                        <x-input-error for="name" class="mt-2" />
                    </div>
                    <div class="block">
                        <x-label value="Correo" for="email" />
                        <x-input wire:model.lazy="email" type="email" id="email" name="email" class="w-full"
                            autocomplete="off" required />
                        <x-input-error for="email" class="mt-2" />
                    </div>
                    <div class="block">
                        <x-label value="Contraseña" for="password" />
                        <x-input wire:model.lazy="password" type="password" id="password" name="password" required
                            autocomplete="off" class="w-full" />
                        <x-input-error for="password" class="mt-2" />
                    </div>
                    @if ($id > 0)
                        <div class="block">
                            <x-label value="Activo" for="active" />
                            <x-select wire:model.lazy="active" id="active" name="active" required class="w-full">
                                <option value="0" @selected(old('acive') == $active)>Inactivo</option>
                                <option value="1" @selected(old('acive') == $active)>Activo</option>
                            </x-select>
                            <x-input-error for="active" class="mt-2" />
                        </div>
                    @endif
                </article>

                @if ($id > 0)
                    <x-button type="button" wire:click="update()" wire:loading.attr="disabled">
                        Actualizar
                    </x-button>
                @else
                    <x-button type="button" wire:click="save()" wire:loading.attr="disabled">
                        Registrar
                    </x-button>
                @endif
            </div>
        </div>
    </x-modal>
</div>
