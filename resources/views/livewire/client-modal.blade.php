<div x-data="{ open: @entangle('showModal') }">
    @if ($errors->getMessages())
        @dd($errors)
    @endif
    <x-button type="button" wire:click="$dispatch('pdf')" class="w-full sm:w-fit gap-3" title="Imprimir reporte">
        <x-lucide-file-text class="size-5" />
        Reportes
    </x-button>

    <x-button wire:click="toggle" class="w-full sm:w-fit gap-3" title="Registrar cliente">
        <x-lucide-plus class="size-5" />
        Cliente
    </x-button>

    <x-modal id="client-modal" maxWidth="md" wire:model.self="showModal">
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                @if ($id > 0)
                    Actualizar
                @else
                    Registrar
                @endif cliente
            </div>

            <div class="mt-4 text-sm text-gray-600">
                <article class="mb-4 flex flex-col gap-4">
                    <div class="block">
                        <x-label value="Nombre" for="name" />
                        <x-input placeholder="Ej: José Navarra" wire:model.lazy="name" type="text" id="name"
                            name="name" class="w-full" autofocus autocomplete="off" required />
                        <x-input-error for="name" class="mt-2" />
                    </div>
                    <div class="block">
                        <x-label value="Teléfono" for="phone" />
                        <x-input placeholder="Ej: 04125121212" wire:model.lazy="phone" type="number" id="phone"
                            name="phone" class="w-full" autofocus autocomplete="off" required />
                        <x-input-error for="phone" class="mt-2" />
                    </div>
                    <div class="block">
                        <x-label value="Correo" for="email" />
                        <x-input placeholder="Ej: correo@email.com" wire:model.lazy="email" type="email"
                            id="email" name="email" class="w-full" autocomplete="off" required />
                        <x-input-error for="email" class="mt-2" />
                    </div>
                    <div class="block">
                        <x-label value="Contraseña" for="password" />
                        <x-input placeholder="Ej: *********" wire:model.lazy="password" type="password" id="password"
                            name="password" required autocomplete="off" class="w-full" />
                        <x-input-error for="password" class="mt-2" />
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
                <x-button type="button" @click="show = false">
                    Cerrar
                </x-button>
            </div>
        </div>
    </x-modal>
</div>
