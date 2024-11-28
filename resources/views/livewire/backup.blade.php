@section('page-title')
    {{ $title }}
@endsection

<div>
    <div class="relative overflow-x-auto">
        <div class="flex flex-col sm:flex-row justify-end gap-3">
            <div class="py-4 px-4 sm:p-4">
                <x-button wire:click="save()">
                    <x-lucide-save class="size-5" />
                    Guardar
                </x-button>
            </div>
        </div>

        <div class="p-4 overflow-x-auto shadow-md">
            <table class="w-full text-sm text-left text-gray-400 bg-white rounded-md border border-neutral-400">
                <thead class="border-b text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Creado
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Peso
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y -space-x-2">
                    @foreach ($backups as $backup)
                        <tr class="">
                            <td class="px-6 py-4">
                                {{ $backup['date'] }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $backup['size'] }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-3">
                                    <x-lucide-cloud-download class="size-5 hover:text-blue-600 cursor-pointer"
                                        wire:click="$dispatch('download', { record: '{{ $backup['key'] }}'})"
                                        title="Descargar" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if (count($backups) === 0)
                <p class="text-center">No se encontraron registros</p>
            @endif
        </div>

    </div>
</div>
