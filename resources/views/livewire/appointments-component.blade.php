@section('page-title')
    Citas
@endsection
<div>

    <div class="p-8 mt-20">
        <div x-data="{ open: @entangle('show_modal'), selectedService: false, selectedPackage: false }">
            <x-modal id="appointment-modal" maxWidth="md" wire:click="show_modal = true" wire:model="show_modal"
                class="mt-16 backdrop-brightness-100">
                <div class="px-6 py-4">
                    <div class="text-lg font-medium text-gray-900">
                        @if ($id >= 1)
                            {{ !Auth::user()->hasAnyRole(['admin', 'employee']) ? 'Ver mi cita' : 'Modificar cita' }}
                        @else
                            Solicitar cita para
                            {{ !empty($selected_date) ? \Carbon\Carbon::createFromFormat('Y-m-d', $selected_date)->translatedFormat('l, d F Y') : '' }}
                        @endif
                    </div>

                    <div class="mt-4 text-sm text-gray-600">
                        <article class="mb-4 grid grid-cols-2 gap-4">
                            @if (!$registered_local)
                                @hasanyrole(['admin', 'employee'])
                                    <div class="col-span-full">
                                        <x-label value="Clientes" />
                                        <x-input :value="$client_name" disabled class="w-full bg-neutral-200" />
                                    </div>
                                @endhasanyrole
                            @endif
                            @if (!empty($clients) && $registered_local)
                                <div class="col-span-full">
                                    <x-label value="Clientes" for="client_id" />
                                    <x-select wire:model.live="client_id" id="client_id" name="client_id" required
                                        class="w-full">
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}"
                                                {{ $client_id === $client->id ? 'selected' : '' }}>
                                                {{ $client->name }}
                                            </option>
                                        @endforeach
                                    </x-select>
                                    <x-input-error for="client_id" class="mt-2" />
                                </div>
                            @endif
                            @if (empty($selected_package))
                                <div class="col-span-full">
                                    <x-label value="Servicio" for="selected_service" />
                                    <x-select wire:model.live="selected_service" id="selected_service"
                                        name="selected_service" required @class([
                                            'w-full',
                                            'bg-neutral-200' =>
                                                !Auth::user()->hasAnyRole(['admin', 'employee']) && $id > 0,
                                        ]) :disabled="!Auth::user()->hasAnyRole(['admin', 'employee']) && $id > 0">
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}"
                                                {{ $selected_service === $service->id ? 'selected' : '' }}>
                                                {{ "$service->name | $$service->price" }}
                                            </option>
                                        @endforeach
                                    </x-select>
                                    <x-input-error for="selected_service" class="mt-2" />
                                </div>
                            @endif
                            @if (empty($selected_service))
                                <div class="col-span-full">
                                    <x-label value="Paquetes" for="selected_package" />
                                    <x-select wire:model.live="selected_package" id="selected_package"
                                        name="selected_package" required @class([
                                            'w-full',
                                            'bg-neutral-200' =>
                                                !Auth::user()->hasAnyRole(['admin', 'employee']) && $id > 0,
                                        ]) :disabled="!Auth::user()->hasAnyRole(['admin', 'employee']) && $id > 0">
                                        @foreach ($packages as $package)
                                            <option value="{{ $package->id }}"
                                                {{ $selected_package === $package->id ? 'selected' : '' }}>
                                                {{ "$package->name | $->price" }}
                                            </option>
                                        @endforeach
                                    </x-select>
                                    <x-input-error for="selected_package" class="mt-2" />
                                </div>
                            @endif
                            <div class="col-span-full">
                                <x-label value="Hora" for="selected_time" />
                                <x-select wire:model.live="selected_time" id="selected_time" name="selected_time"
                                    required :disabled="!Auth::user()->hasAnyRole(['admin', 'employee']) && $id > 0" @class([
                                        'w-full',
                                        'bg-neutral-200' =>
                                            !Auth::user()->hasAnyRole(['admin', 'employee']) && $id > 0,
                                    ])>
                                    @foreach ($hours as $hour)
                                        <option value="{{ $hour['value'] }}">{{ $hour['text'] }}</option>
                                    @endforeach

                                </x-select>

                                <x-input-error for="selected_time" class="mt-2" />
                            </div>
                            @if (Auth::user()->hasRole('admin') && $id >= 1)
                                <div class="col-span-full">
                                    <x-label value="Estado" for="status" />
                                    <x-select wire:model.live="status" id="status" name="status" required
                                        class="w-full">
                                        <option value="0" {{ $status === 0 ? 'selected' : '' }}>Pendiente</option>
                                        <option value="1" {{ $status === 1 ? 'selected' : '' }}>Pagado</option>
                                    </x-select>
                                    <x-input-error for="status" class="mt-2" />
                                </div>
                                <div wire:loading wire:target="status" class="w-full col-span-full">
                                    <p class="text-gray-600">Cargando sección de pago, por favor espere...</p>
                                </div>
                                @if ($status === '1')
                                    <div class="col-span-full sm:col-span-1">
                                        <x-label value="Tipo de pago" for="type" />
                                        <x-select wire:model.live="type" id="type" name="type" required
                                            class="w-full">
                                            @foreach (App\Enum\Payment\TypeEnum::cases() as $enum)
                                                @if ($currency === 'Divisas' && $enum->name === 'PagoMóvil')
                                                    @continue
                                                @endif
                                                @if ($currency === 'Bs' && $enum->name === 'Paypal')
                                                    @continue
                                                @endif
                                                <option value="{{ $enum->value }}"
                                                    {{ $enum->value === $type ? 'selected' : '' }}>
                                                    {{ $enum->name }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                        <x-input-error for="type" class="mt-2" />
                                    </div>
                                    <div class="col-span-full sm:col-span-1">
                                        <x-label value="Tipo de moneda" for="currency" />
                                        <x-select wire:model.live="currency" id="currency" name="currency" required
                                            class="w-full">
                                            @foreach (App\Enum\Payment\CurrencyEnum::cases() as $enum)
                                                @if ($type === 'Paypal' && $enum->name === 'Bs')
                                                    @continue
                                                @endif
                                                <option value="{{ $enum->value }}"
                                                    {{ $enum->value === $currency ? 'selected' : '' }}>
                                                    {{ $enum->name }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                        <x-input-error for="currency" class="mt-2" />
                                    </div>
                                    <div class="col-span-full sm:col-span-1">
                                        <x-label value="Pago" for="payed" />
                                        <x-input wire:model.lazy="payed" type="number" id="payed" name="payed"
                                            required placeholder="Ej: 4" class="w-full" />
                                        <x-input-error for="payed" class="mt-2" />
                                    </div>
                                    <div class="col-span-full sm:col-span-1">
                                        <x-label value="Referencia" for="ref" />
                                        <x-input wire:model.lazy="ref" placeholder="Ej: 0000" id="ref"
                                            name="ref" class="w-full" />
                                        <x-input-error for="ref" class="mt-2" />
                                    </div>
                                @endif
                            @endif
                        </article>

                        @if ($id >= 1)
                            @if (Auth::user()->hasAnyRole(['admin', 'employee']))
                                <x-button wire:target="selected_service, selected_package" type="button"
                                    wire:click="update()" wire:loading.attr="disabled">
                                    Actualizar
                                </x-button>
                                @if (Auth::user()->hasRole('admin'))
                                    <x-danger-button type="button" wire:click="delete()">
                                        Borrar
                                    </x-danger-button>
                                @endif
                            @endif
                        @else
                            <x-button wire:target="selected_service, selected_package" type="button"
                                wire:click="save()" wire:loading.attr="disabled">
                                Solicitar
                            </x-button>
                        @endif
                    </div>
                </div>
            </x-modal>
        </div>

        <livewire:appointments-calendar week-starts-at="1" day-of-week-view="components/calendar-days-header"
            day-view="components/calendar-day" />

        @if (Auth::user()->hasRole('admin'))
            <div class="p-4 overflow-x-auto shadow-md">
                <table class="w-full text-sm text-left text-gray-400 bg-white rounded-md border border-neutral-400">
                    <thead class="border-b text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Cita
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Precio
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Cliente
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Pagado
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Pago
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Moneda
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Referencia
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Cita para
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y -space-x-2">
                        @foreach ($appointments as $appointment)
                            <tr class="">
                                <td class="px-6 py-4">
                                    {{ $appointment->service->name ?? $appointment->package->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $appointment->service->price ?? $appointment->package->price }}
                                </td>
                                <td @class([
                                    'px-6 py-4',
                                    'text-green-500' => $appointment->status,
                                    'text-red-500' => !$appointment->status,
                                ])>
                                    {{ $appointment->status ? 'Pagado' : 'Pendiente' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $appointment->user->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $appointment->payment->payed ?? '' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $appointment->payment->type->name ?? '' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $appointment->payment->currency->name ?? '' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $appointment->payment->ref ?? '' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d h:i:s', $appointment->picked_date)->translatedFormat('l, d F Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $appointments->links() }}
                @if (count($appointments) === 0)
                    <p class="text-center">No se encontraron registros</p>
                @endif
            </div>
        @endif
    </div>
</div>
