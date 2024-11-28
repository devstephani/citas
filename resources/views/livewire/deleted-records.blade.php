@section('page-title')
    {{ $title }}
@endsection

<div>
    <div class="relative overflow-x-auto">
        <div class="p-4 overflow-x-auto shadow-md">
            <table class="w-full text-sm text-left text-gray-400 bg-white rounded-md border border-neutral-400">
                <thead class="border-b text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Módulo
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Borrado
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $record)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $record['title'] }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $record['model'] }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $record['deleted_at']->format('d-m-Y g:i:s a') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-3">
                                    <x-lucide-archive-restore class="size-5 hover:text-blue-600 cursor-pointer"
                                        wire:click="$dispatch('recover', { record: {{ $record['id'] }}, model: '{{ $record['model'] }}'})"
                                        title="Recuperar" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if (count($records) === 0)
                <p class="text-center">No se encontraron registros</p>
            @endif
        </div>

    </div>
</div>
