@section('page-title')
    {{ $title }}
@endsection

<div>
    @role('admin')
        <div class="relative overflow-x-auto">
            <div class="flex flex-col sm:flex-row justify-between gap-3">
                <x-search />

                <livewire:employee-modal />
            </div>
        </div>

        <div class="p-4 overflow-x-auto shadow-md">
            <table class="w-full text-sm text-left text-gray-400 bg-white rounded-md border border-neutral-400">
                <thead class="border-b text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Foto
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Correo
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Servicios
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Activo
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Registrado
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <img src="{{ $employee->get_image() }}" class="size-20 rounded-md" />
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $employee->user->name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $employee->user->email }}
                            </td>
                            <td class="px-6 py-4">
                                @if (count($employee->services) > 0)
                                    <ul class="flex flex-col gap-2">
                                        @foreach ($employee->services as $service)
                                            <li class="list-disc">{{ $service->name }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-600">Sin servicios</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($employee->user->active)
                                    <x-lucide-circle-check
                                        wire:click="$dispatch('toggle_active', { employee: {{ $employee->id }} })"
                                        class="cursor-pointer size-5 text-green-700" />
                                @else
                                    <x-lucide-circle-slash
                                        wire:click="$dispatch('toggle_active', { employee: {{ $employee->id }} })"
                                        class="cursor-pointer size-5 text-red-700" />
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                {{ $employee->created_at->format('d-m-Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-3">
                                    <x-lucide-file-text class="size-5 hover:text-blue-600 cursor-pointer"
                                        wire:click="$dispatch('employee_pdf', { record: {{ $employee->id }}})" />
                                    <x-lucide-alarm-clock class="size-5 hover:text-blue-600 cursor-pointer"
                                        wire:click="$dispatch('see_attendances', { record: {{ $employee->id }}})" />
                                    <x-lucide-pencil class="size-5 hover:text-blue-600 cursor-pointer"
                                        wire:click="$dispatch('edit', { record: {{ $employee->id }}})" />
                                    <x-lucide-trash class="size-5 hover:text-blue-600 cursor-pointer"
                                        onclick="delete_alert({{ $employee->id }})" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $employees->links() }}
            @if (count($employees) === 0)
                <p class="text-center">No se encontraron registros</p>
            @endif
        </div>
    </div>
@endrole
</div>
