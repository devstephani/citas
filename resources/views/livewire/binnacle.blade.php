@section('page-title')
    Bitácora
@endsection

<div>
    @role('admin')
        <div class="relative overflow-x-auto">
            <div class="p-4 overflow-x-auto shadow-md">
                <table class="w-full text-sm text-left text-gray-400 bg-white rounded-md border border-neutral-400">
                    <thead class="border-b text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Usuario
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Mensaje
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Registrado
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $log->user->name }}
                                </th>
                                <td class="px-6 py-4">
                                    @if ($log->status === 'success')
                                        <x-lucide-circle-check class="size-4 text-green-600" title="Exitoso" />
                                    @elseif ($log->status === 'warning')
                                        <x-lucide-circle-alert class="size-4 text-yellow-600" title="Advertencia" />
                                    @elseif ($log->status === 'info')
                                        <x-lucide-info class="size-4 text-blue-600" title="Información" />
                                    @else
                                        <x-lucide-circle-x class="size-4 text-red-600" title="Hubo un error" />
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ $log->message }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $log->created_at->format('d-m-Y g:i:s a') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $logs->links() }}
                @if (count($logs) === 0)
                    <p class="text-center">No se encontraron registros</p>
                @endif
            </div>

        </div>
    @endrole
</div>
