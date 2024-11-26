@section('page-title')
    {{ $title }}
@endsection

<div>
    @role('client')
        <x-page-title :title="$title" :subtitle="$subtitle" />
        <section class="mt-5 our-rooms-area pb-100">
            <div class="container">
                <div class="section-title">
                    <span>Servicios</span>
                    <h2>Disfruta de nuestros servicios</h2>
                </div>
                <div class="row">
                    @foreach ($services as $service)
                        <div class="col-lg-4 col-sm-6">
                            <div class="single-rooms-three-wrap">
                                <div class="single-rooms-three">
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="Image">
                                    <div class="single-rooms-three-content">
                                        <h3>{{ $service->name }}</h3>
                                        <p>{{ $service->description }}</p>
                                        <span class="price">{{ "$service->price$" }}</span>
                                        <a href="{{ route('appointments') }}" class="default-btn">
                                            Reserva en línea
                                            <i class="flaticon-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{ $services->links() }}
                </div>
            </div>
        </section>
    @endrole

    @hasanyrole(['admin', 'employee'])
        <div class="relative overflow-x-auto">
            <div class="flex flex-col sm:flex-row justify-between gap-3">

                <x-search />
                <div class="py-4 px-4 sm:p-4">
                    <livewire:service-modal />
                </div>
            </div>

            <div class="p-4 overflow-x-auto shadow-md">
                <table class="w-full text-sm text-left text-gray-400 bg-white rounded-md border border-neutral-400">
                    <thead class="border-b text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Imágen
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nombre
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Descripción
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Empleado
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Tipo
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Precio
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Publicado por
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Activo
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y -space-x-2">
                        @foreach ($services as $service)
                            <tr class="">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <img src="{{ asset('storage/' . $service->image) }}" class="size-20 rounded-md" />
                                </th>
                                <td class="px-6 py-4">
                                    {{ $service->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $service->description }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $service->employee->user->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $service->type->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $service->price }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $service->user->name }}
                                </td>
                                <td class="px-6 py-4">
                                    @role('admin')
                                        @if ($service->active)
                                            <x-lucide-circle-check
                                                wire:click="$dispatch('toggle_active', { service: {{ $service->id }} })"
                                                class="cursor-pointer size-5 text-green-700" />
                                        @else
                                            <x-lucide-circle-slash
                                                wire:click="$dispatch('toggle_active', { service: {{ $service->id }} })"
                                                class="cursor-pointer size-5 text-red-700" />
                                        @endif
                                    @endrole
                                    @role('employee')
                                        @if ($service->active)
                                            <x-lucide-circle-check class="size-5 text-green-700" />
                                        @else
                                            <x-lucide-circle-slash class="size-5 text-red-700" />
                                        @endif
                                    @endrole
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-3">
                                        <x-lucide-pencil class="size-5 hover:text-blue-600 cursor-pointer"
                                            wire:click="$dispatch('edit', { record: {{ $service->id }}})" />
                                        @role('admin')
                                            <x-lucide-trash class="size-5 hover:text-blue-600 cursor-pointer"
                                                onclick="delete_alert({{ $service->id }})" />
                                        @endrole
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $services->links() }}
                @if (count($services) === 0)
                    <p class="text-center">No se encontraron registros</p>
                @endif
            </div>

        </div>
    @endhasallroles
</div>
