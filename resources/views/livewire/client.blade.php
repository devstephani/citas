<div>
    @role('admin')
        <div class="relative overflow-x-auto">
            <div class="flex justify-between">

                <x-search />
                <div class="p-4 bg-white dark:bg-gray-900">
                    <livewire:client-modal />
                </div>
            </div>

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Correo
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
                    @foreach ($clients as $client)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $client->name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $client->email }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($client->active)
                                    <x-lucide-circle-check
                                        wire:click="$dispatch('toggle_active', { user: {{ $client->id }} })"
                                        class="cursor-pointer size-5 text-green-700" />
                                @else
                                    <x-lucide-circle-slash
                                        wire:click="$dispatch('toggle_active', { user: {{ $client->id }} })"
                                        class="cursor-pointer size-5 text-red-700" />
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                {{ $client->created_at->format('d-m-Y g:i:s a') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-3">
                                    <x-lucide-pencil class="size-5 cursor-pointer"
                                        wire:click="$dispatch('edit', { record: {{ $client->id }}})" />
                                    <x-lucide-trash class="size-5 cursor-pointer"
                                        onclick="delete_alert({{ $client->id }})" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $clients->links() }}
            @if (count($clients) === 0)
                <p class="text-center">No se encontraron registros</p>
            @endif
        </div>
    @endrole
</div>
