<div x-data="{ open: @entangle('showModal') }">
    <x-button wire:click="toggle" class="w-full sm:w-fit gap-3">
        <x-lucide-plus class="size-5" />
        Servicio
    </x-button>

    <x-modal id="service-modal" maxWidth="md" wire:model="showModal">
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                @if ($id > 0)
                    Actualizar
                @else
                    Registrar
                @endif servicio
            </div>

            <div class="mt-4 text-sm text-gray-600">
                <article class="mb-4 flex flex-col gap-4">
                    <div class="block">
                        <x-label value="Nombre" for="name" />
                        <x-input wire:model.lazy="name" type="text" id="name" name="name" class="w-full" placeholder="Ej: Estética"
                            autofocus autocomplete="off" required />
                        <x-input-error for="name" class="mt-2" />
                    </div>
                    <div class="block">
                        <x-label value="Descripción" for="description" />
                        <x-textarea wire:model.lazy="description" id="description" name="description" class="w-full" placeholder="Ej: Belleza"
                            required></x-textarea>
                        <x-input-error for="description" class="mt-2" />
                    </div>
                    <div class="block">
                        <x-label value="Precio" for="price" />
                        <x-input wire:model.lazy="price" type="number" id="price" name="price" required placeholder="Ej: 5"
                            class="w-full" />
                        <x-input-error for="price" class="mt-2" />
                    </div>
                    <div class="block">
                        <x-label value="Tipo" for="type" />
                        <x-select wire:model.lazy="type" id="type" name="type" required class="w-full">
                            @foreach (App\Enum\Service\TypeEnum::cases() as $enum)
                                <option value="{{ $enum->value }}" {{ $enum->value === $type ? 'selected' : '' }}>
                                    {{ $enum->name }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error for="type" class="mt-2" />
                    </div>
                    <div class="block">
                        <x-label value="Empleado" for="employee_id" />
                        <x-select wire:click="select_employee($event.target.value)" wire:model.lazy="employee_id"
                            id="employee_id" name="employee_id" required class="w-full">
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}"
                                    {{ $employee->id == $employee_id ? 'selected' : '' }}>
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error for="employee_id" class="mt-2" />
                    </div>
                    @if ($id > 0)
                        <div class="block">
                            <x-label value="Activo" for="active" />
                            <x-select wire:model.lazy="active" id="active" name="active" required class="w-full">
                                <option value="0">Inactivo</option>
                                <option value="1">Activo</option>
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
