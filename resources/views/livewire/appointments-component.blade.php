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
                            @if (!$registered_local && $id === 0 && !is_null($frequent_appointments) && $frequent_appointments->count() > 0)
                                <div class="col-span-full flex flex-col w-full overflow-x-auto">
                                    <p class="flex-auto">
                                        Citas frecuentes
                                    </p>
                                    <div class="flex overflow-x-auto mt-2">
                                        <ul class="p-2 flex flex-row gap-3 whitespace-nowrap">
                                            @foreach ($frequent_appointments as $frequent_appointment)
                                                @php
                                                    $frequent_appointment = \App\Models\Appointment::find(
                                                        $frequent_appointment->last_id,
                                                    );
                                                    $name =
                                                        $frequent_appointment->service->name ??
                                                        $frequent_appointment->package->name;
                                                    $hour = \Carbon\Carbon::createFromFormat(
                                                        'Y-m-d H:i:s',
                                                        $frequent_appointment->picked_date,
                                                    )->format('h:i A');
                                                @endphp
                                                <li class="max-w-fit">
                                                    <button
                                                        wire:click="$dispatch('set_appointment', { record: {{ $frequent_appointment->id }} })"
                                                        type="button" @class([
                                                            'rounded-md border px-3.5 py-1.5 text-xs transition-all hover:bg-purple-400 hover:text-white shadow border-neutral-400 hover:border-purple-200',
                                                            'bg-purple-400 text-white border-purple-200' =>
                                                                $selected_frequent_appointment === $frequent_appointment->id,
                                                        ]) />
                                                    {{ "$name | $hour" }}
                                                    </button>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                            @if ($id > 0)
                                @hasanyrole(['admin', 'employee'])
                                    <div class="col-span-full">
                                        <x-label value="Clientes" />
                                        <x-input :value="$client_name" disabled class="w-full bg-neutral-200" />
                                    </div>
                                @endhasanyrole
                            @endif
                            @if (!empty($clients) && $registered_local && $id === 0)
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
                            @if (is_null($selected_package))
                                <div class="col-span-full">
                                    <x-label value="Servicio" for="selected_service" />
                                    <x-select wire:model.live="selected_service" id="selected_service"
                                        name="selected_service" required @class([
                                            'w-full',
                                            'bg-neutral-200' =>
                                                (!Auth::user()->hasAnyRole(['admin', 'employee']) && $id > 0) ||
                                                $modifying > 0,
                                        ]) :disabled="(!Auth::user()->hasAnyRole(['admin', 'employee']) && $id > 0) ||
                                            $modifying > 0">
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}"
                                                {{ $selected_service === $service->id ? 'selected' : '' }}>
                                                {{ $service->name }}
                                            </option>
                                        @endforeach
                                    </x-select>
                                    <x-input-error for="selected_service" class="mt-2" />
                                </div>
                            @endif
                            @hasanyrole(['admin', 'client'])
                                @if (is_null($selected_service))
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
                                                    {{ $package->name }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                        <x-input-error for="selected_package" class="mt-2" />
                                    </div>
                                @endif
                            @endhasanyrole
                            <div class="col-span-full">
                                <x-label value="Hora" for="selected_time" />
                                <x-select wire:model.live="selected_time" id="selected_time" name="selected_time"
                                    required :disabled="!Auth::user()->hasAnyRole(['admin', 'employee']) && $id > 0" @class([
                                        'w-full',
                                        'bg-neutral-200' =>
                                            !Auth::user()->hasAnyRole(['admin', 'employee']) && $id > 0,
                                    ])>
                                    @foreach ($hours as $hour)
                                        <option value="{{ $hour['value'] }}"
                                            {{ !is_null($currentTimeFormatted) && $currentTimeFormatted > $hour['value'] ? 'disabled' : '' }}>
                                            {{ $hour['text'] }}</option>
                                    @endforeach

                                </x-select>

                                <x-input-error for="selected_time" class="mt-2" />
                            </div>
                            @if (Auth::user()->hasRole('admin') && $id >= 1)
                                <div class="col-span-full">
                                    <x-label value="Estado" for="status" />
                                    <x-select wire:model.live="status" id="status" name="status" required
                                        @class(['w-full', 'bg-neutral-200' => $modifying > 0]) :disabled="$modifying > 0">
                                        <option value="0" {{ $status === 0 ? 'selected' : '' }}>Pendiente</option>
                                        <option value="1" {{ $status === 1 ? 'selected' : '' }}>Pagado</option>
                                        <option value="2" {{ $status === 2 ? 'selected' : '' }}>Cancelado</option>
                                    </x-select>
                                    <x-input-error for="status" class="mt-2" />
                                </div>
                                <div class="col-span-full">
                                    <x-label value="Nota" for="note" />
                                    <x-textarea wire:model.lazy="note" id="note" name="note" class="w-full"
                                        placeholder="Ej: El pago no puede ser verificado" required></x-textarea>
                                    <x-input-error for="note" class="mt-2" />
                                </div>
                            @endif
                            @php
                                $service_price = $m_service->price ?? 0;
                                $package_price = $m_package->price ?? 0;
                                $base_price = ($service_price ?? $package_price) * ($this->discount ? 0.95 : 1);
                                $price_to_bs = round($base_price * $currency_api, 2);
                            @endphp
                            <div class="col-span-full border border-neutral-400 p-4 rounded-md">
                                <ul class="flex flex-col gap-3">
                                    <li class="font-bold">Datos para el pago</li>
                                    <ul class="grid grid-cols-2">
                                        <li>0102</li>
                                        <li></li>
                                        <li>04243004510</li>
                                        <li class="font-semibold">Monto a pagar</li>
                                        <li>30956447</li>
                                        <li>{{ $price_to_bs }}Bs o {{ $base_price }}$</li>
                                    </ul>
                                </ul>
                                @role('client')
                                    <p class="mt-4 text-neutral-600">{{ $note }}</p>
                                @endrole
                            </div>
                            <div class="col-span-full sm:col-span-1">
                                <x-label value="Tipo de pago" for="type" />
                                <x-select wire:model.live="type" id="type" name="type" required
                                    :disabled="Auth::user()->hasAnyRole(['admin', 'employee']) && $id > 0" @class([
                                        'w-full',
                                        'bg-neutral-200' =>
                                            Auth::user()->hasAnyRole(['admin', 'employee']) && $id > 0,
                                    ])>
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
                                    @class([
                                        'w-full',
                                        'bg-neutral-200' =>
                                            Auth::user()->hasAnyRole(['admin', 'employee']) && $id > 0,
                                    ]) :disabled="Auth::user()->hasRole(['admin', 'employee']) && $id > 0">
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
                                    required placeholder="Ej: 4" @class([
                                        'w-full',
                                        'bg-neutral-200' =>
                                            Auth::user()->hasAnyRole(['admin', 'employee']) && $id > 0,
                                    ]) step="0.02"
                                    :disabled="Auth::user()->hasRole(['admin', 'employee']) && $id > 0" />
                                <x-input-error for="payed" class="mt-2" />
                            </div>
                            <div class="col-span-full sm:col-span-1">
                                <x-label value="Referencia" for="ref" />
                                <x-input wire:model.lazy="ref" placeholder="Ej: 0000" id="ref" name="ref"
                                    @class([
                                        'w-full',
                                        'bg-neutral-200' =>
                                            Auth::user()->hasAnyRole(['admin', 'employee']) && $id > 0,
                                    ]) :disabled="Auth::user()->hasRole(['admin', 'employee']) && $id > 0" />
                                <x-input-error for="ref" class="mt-2" />
                            </div>
                        </article>

                        @if ($id >= 1)
                            <x-button wire:target="selected_service, selected_package" type="button"
                                wire:click="update()" wire:loading.attr="disabled">
                                Actualizar
                            </x-button>
                            @if (Auth::user()->hasAnyRole(['admin', 'employee']))
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
            day-view="components/calendar-day" before-calendar-view="components/before-calendar-view" />

        @if (Auth::user()->hasAnyRole(['admin', 'employee']))
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
                                Descuento
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
                                Confirmada
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Cita para
                            </th>
                            @role('admin')
                                <th scope="col" class="px-6 py-3">
                                    Acciones
                                </th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody class="divide-y -space-x-2">
                        @foreach ($appointments as $appointment)
                            @php
                                $payed = 0;
                                $discount = 0;

                                if ($appointment->payment) {
                                    $payed = $appointment->payment->payed;
                                    $discount = $payed * ($appointment->discount ? 0.05 : 0);
                                }
                            @endphp
                            <tr class="">
                                <td class="px-6 py-4">
                                    {{ $appointment->service->name ?? $appointment->package->name }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $price = $appointment->service->price ?? $appointment->package->price;
                                    @endphp
                                    {{ $price ? "$price$" : '' }}
                                </td>
                                <td @class([
                                    'px-6 py-4',
                                    'text-green-500' => $appointment->status === 1,
                                    'text-red-500' => $appointment->status === 0,
                                ])>
                                    {{ $appointment->status === 0 ? 'Pendiente' : ($appointment->status === 1 ? 'Pagado' : 'Cancelado') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $appointment->user->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $payed ? "$payed$" : '' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $discount ? "$discount$" : '' }}
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
                                    <p @class([
                                        'text-green-400' => $appointment->accepted,
                                        'text-red-400' => !$appointment->accepted,
                                    ])>
                                        {{ $appointment->accepted ? 'Si' : 'No' }}
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $appointment->picked_date)->translatedFormat('l, d F Y') }}
                                </td>
                                @role('admin')
                                    @if ($appointment->accepted)
                                        <td class="px-6 py-4">
                                            <x-button wire:click="confirm({{ $appointment->id }})">Confirmar</x-button>
                                            <x-button wire:click="modify({{ $appointment->id }})">Re-agendar</x-button>
                                        </td>
                                    @endif
                                @endrole('admin')
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
        @if (Auth::user()->hasRole('client'))
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
                                Descuento
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
                            <th scope="col" class="px-6 py-3">
                                Puntuar
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y -space-x-2">
                        @foreach ($appointments as $appointment)
                            @php
                                $payed = 0;
                                $discount = 0;

                                if ($appointment->payment) {
                                    $payed = $appointment->payment->payed;
                                    $discount = $payed * ($appointment->discount ? 0.05 : 0);
                                }

                                $stars = $appointment->stars;
                            @endphp
                            <tr class="">
                                <td class="px-6 py-4">
                                    {{ $appointment->service->name ?? $appointment->package->name }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $price = $appointment->service->price ?? $appointment->package->price;
                                    @endphp
                                    {{ $price ? "$price$" : '' }}
                                </td>
                                <td @class([
                                    'px-6 py-4',
                                    'text-green-500' => $appointment->status === 1,
                                    'text-red-500' => $appointment->status === 0,
                                ])>
                                    {{ $appointment->status === 0 ? 'Pendiente' : ($appointment->status === 1 ? 'Pagado' : 'Cancelado') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $appointment->user->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $payed ? "$payed$" : '' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $discount ? "$discount$" : '' }}
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
                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $appointment->picked_date)->translatedFormat('l, d F Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-1">
                                        @php
                                            $options = [1, 2, 3, 4, 5];
                                        @endphp
                                        @foreach ($options as $index)
                                            @if (!is_null($stars))
                                                <x-lucide-star @class(['size-4', 'fill-yellow-400' => $stars >= $index]) title="1 estrella" />
                                            @else
                                                <x-lucide-star @class([
                                                    'size-4',
                                                    'cursor-pointer hover:fill-yellow-400' => is_null($stars),
                                                ])
                                                    wire:click="rate({{ $index }}, {record: {{ $appointment->id }}})"
                                                    title="{{ $index }} estrella{{ $index >= 2 ? 's' : '' }}" />
                                            @endif
                                        @endforeach
                                    </div>
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
