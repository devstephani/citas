<div class="py-4 px-4 sm:p-4">
    @if ($show_attendance_modal)
        <div x-data="{ open: @entangle('show_attendance_modal') }">
            <x-modal id="attendance-modal" maxWidth="md" wire:click.away="show_attendance_modal = false"
                wire:model="show_attendance_modal">
                <div class="px-6 py-4">
                    <div class="text-lg font-medium text-gray-900">
                        Asistencia de {{ $name }}
                    </div>

                    <x-label for="attendance_date" value="{{ __('Fecha a buscar') }}" />
                    <x-input wire:model.live="attendance_date" type="date" :min="$initial_date" :max="$current_date"
                        class="w-full mt-2" />

                    <div wire:loading wire:target="attendance_date">
                        <p class="text-gray-600">Cargando asistencias, por favor espere...</p>
                    </div>

                    <div class="mt-4 text-sm text-gray-600">
                        <ul class="mb-4 grid grid-cols-5 gap-4">
                            @foreach ($employee_attendances as $attendance)
                                <li class="col-span-1">
                                    <span class="font-bold">
                                        {{ $attendance->type ? 'Entrada' : 'Salida' }}
                                    </span>
                                </li>
                                <li class="col-span-4">
                                    {{ $attendance->created_at->translatedFormat('l, d F Y - h:i:s a') }}
                                </li>
                            @endforeach
                        </ul>

                        <x-button type="button" wire:click="show_attendance_modal = false">
                            Cerrar
                        </x-button>
                    </div>
                </div>
            </x-modal>
        </div>
    @endif

    <div x-data="{ open: @entangle('showModal') }">
        <x-button wire:click="$dispatch('pdf')" class="w-full sm:w-fit gap-3" title="Imprimir reporte">
            <x-lucide-file-text class="size-5" />
            Asistencias
        </x-button>
        <x-button wire:click="toggle" class="w-full sm:w-fit gap-3" title="Registrar empleado">
            <x-lucide-plus class="size-5" />
            Empleado
        </x-button>

        <x-modal id="employees-modal" maxWidth="md" wire:model="showModal">
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
                            <x-input placeholder="Ej: Andrés Contreras" wire:model.lazy="name" type="text"
                                id="name" name="name" class="w-full" autofocus autocomplete="off" required />
                            <x-input-error for="name" class="mt-2" />
                        </div>
                        <div class="block">
                            <x-label value="Correo" for="email" />
                            <input type="email" name="email" style="display:none">

                            <x-input placeholder="Ej: correo@email.com" wire:model.lazy="email" type="email"
                                id="email" name="email" class="w-full" autocomplete="new-password" required />
                            <x-input-error for="email" class="mt-2" />
                        </div>
                        <div class="block">
                            <x-label value="Contraseña" for="password" />
                            <x-input placeholder="Ej: *********" wire:model.lazy="password" type="password"
                                id="password" name="password" required autocomplete="off" class="w-full" />
                            <x-input-error for="password" class="mt-2" />
                        </div>
                        <div class="block">
                            <x-label value="Descripción" for="description" />
                            <x-textarea placeholder="Ej: Maquillador profesional" wire:model.lazy="description"
                                id="description" name="description" class="w-full" required></x-textarea>
                            <x-input-error for="description" class="mt-2" />
                        </div>

                        <div class="block">
                            <x-label value="Servicios" for="service_ids" />
                            <x-select wire:model.lazy="service_ids" id="service_ids" name="service_ids[]" multiple
                                required class="w-full" no_default>
                                @foreach ($available_services as $service)
                                    <option value="{{ $service->id }}"
                                        {{ in_array($service->id, $services) ? 'selected' : '' }}>
                                        {{ $service->name }}
                                    </option>
                                @endforeach
                            </x-select>
                            <x-input-error for="service_ids" class="mt-2" />
                        </div>

                        @if ($id > 0)
                            <div class="block">
                                <x-label value="Activo" for="active" />
                                <x-select wire:model.lazy="active" id="active" name="active" required
                                    class="w-full">
                                    <option value="0" @selected(old('acive') == $active)>Inactivo</option>
                                    <option value="1" @selected(old('acive') == $active)>Activo</option>
                                </x-select>
                                <x-input-error for="active" class="mt-2" />
                            </div>
                        @endif

                        <x-label value="Imágen" for="photo" />

                        <x-input type="file" wire:model="photo" accept=".jpg" />

                        <x-input-error for="photo" class="mt-2" />
                        @if (($photo && $id < 1) || ($photo && $prevImg !== $photo))
                            <img src="{{ $photo->temporaryUrl() }}">
                        @endif
                        @if ($prevImg === $photo && $id > 0)
                            <img src="{{ asset('storage/' . $photo) }}">
                        @endif
                        <div wire:loading wire:target="photo">
                            <p class="text-gray-600">Cargando imágen, por favor espere...</p>
                        </div>
                    </article>

                    @if ($id > 0)
                        <x-button type="button" wire:click="update()" wire:loading.attr="disabled">
                            Actualizar
                        </x-button>
                </div>
            @else
                <x-button type="button" wire:click="save()" wire:loading.attr="disabled">
                    Registrar
                </x-button>
                @endif
            </div>
        </x-modal>
    </div>
</div>
