@section('page-title')
    {{ $title }}
@endsection

<div>
    @role('client')
        <x-page-title :title="$title" :subtitle="$subtitle" />
        <section class="exclusive-offers-area-four pt-100 pb-70">
            <div class="container">
                <div class="section-title">
                    <h2>Disfruta de nuestros paquetes</h2>
                    <span>Paquetes</span>
                </div>
                <div class="row">
                    @foreach ($packages as $package)
                        <div class="col-lg-4 col-sm-6">
                            <div class="single-exclusive-four">
                                <img src="{{ asset('storage/' . $package->image) }}" alt="Image">
                                <div class="exclusive-content">
                                    <h3>{{ $package->name }}</h3>
                                    <span class="review">
                                        <a href="#">Precio: {{ $package->price }}$ -
                                            ({{ $package->appointments()->count() }} Citas)
                                        </a>
                                    </span>
                                    <p>{{ $package->description }}</p>
                                    <a href="{{ route('appointments', ['package_id' => $package->id]) }}"
                                        class="default-btn">
                                        Reserva en línea
                                        <i class="flaticon-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{ $packages->links() }}
                </div>
            </div>
        </section>
        <!-- End Exclusive Offers Area -->
    @endrole

    @hasanyrole(['admin', 'employee'])
        <div class="relative overflow-x-auto">
            <div class="flex flex-col sm:flex-row justify-between gap-3">

                <x-search />
                <div class="py-4 px-4 sm:p-4">
                    <livewire:package-modal />
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
                                Servicios
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
                    <tbody>
                        @foreach ($packages as $package)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <img src="{{ asset('storage/' . $package->image) }}" class="size-20 rounded-md" />
                                </th>
                                <td class="px-6 py-4">
                                    {{ $package->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $package->description }}
                                </td>
                                <td class="px-6 py-4">
                                    <ul class="flex flex-col gap-2">
                                        @foreach ($package->services as $service)
                                            <li class="list-disc">{{ $service->name }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $package->price }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $package->user->name }}
                                </td>
                                <td class="px-6 py-4">
                                    @role('admin')
                                        @if ($package->active)
                                            <x-lucide-circle-check
                                                wire:click="$dispatch('toggle_active', { package: {{ $package->id }} })"
                                                class="cursor-pointer size-5 text-green-700" title="Marcar inactivo" />
                                        @else
                                            <x-lucide-circle-slash
                                                wire:click="$dispatch('toggle_active', { package: {{ $package->id }} })"
                                                class="cursor-pointer size-5 text-red-700" title="Marcar activo" />
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
                                            wire:click="$dispatch('edit', { record: {{ $package->id }}})"
                                            title="Editar" />
                                        @role('admin')
                                            <x-lucide-trash class="size-5 hover:text-blue-600 cursor-pointer"
                                                onclick="delete_alert({{ $package->id }})" title="Eliminar" />
                                        @endrole
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $packages->links() }}
                @if (count($packages) === 0)
                    <p class="text-center">No se encontraron registros</p>
                @endif
            </div>
        </div>
    @endhasallroles
</div>
