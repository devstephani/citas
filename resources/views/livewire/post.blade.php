@section('page-title')
    {{ $title }}
@endsection

<div>
    <div class="relative overflow-x-auto">
        <div class="flex flex-col sm:flex-row justify-between gap-3">

            <x-search />
            <div class="py-4 px-4 sm:p-4">
                <livewire:post-modal />
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
                            Título
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Interacción
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Publicado por
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Publicado
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
                    @foreach ($posts as $post)
                        <tr class="">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <img src="{{ asset('storage/' . $post->image) }}" class="size-20 rounded-md" />
                            </th>
                            <td class="px-6 py-4">
                                {{ $post->title }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-3">
                                    @php
                                        $reactions = $post->get_reactions();
                                    @endphp
                                    <p class="inline-flex items-center gap-3">
                                        {{ $reactions[0] }}
                                        <x-lucide-thumbs-up class="size-4" />
                                    </p>
                                    <p class="inline-flex items-center gap-3">
                                        {{ $reactions[1] }}
                                        <x-lucide-thumbs-down class="size-4" />
                                    </p>
                                    <p class="inline-flex items-center gap-3">
                                        {{ count($post->comments) }}
                                        <x-lucide-message-circle class="size-4" />
                                    </p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                {{ $post->user->name }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($post->active)
                                    <x-lucide-circle-check
                                        wire:click="$dispatch('toggle_active', { record: {{ $post->id }} })"
                                        class="cursor-pointer size-5 text-green-700" />
                                @else
                                    <x-lucide-circle-slash
                                        wire:click="$dispatch('toggle_active', { record: {{ $post->id }} })"
                                        class="cursor-pointer size-5 text-red-700" />
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                {{ $post->created_at->format('d-m-Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-3">
                                    <a href="{{ route('post.id', $post->id) }}">
                                        <x-lucide-eye class="size-5 hover:text-blue-600 cursor-pointer" />
                                    </a>
                                    <x-lucide-pencil class="size-5 hover:text-blue-600 cursor-pointer"
                                        wire:click="$dispatch('edit', { record: {{ $post->id }}})" />
                                    @role('admin')
                                        <x-lucide-trash class="size-5 hover:text-blue-600 cursor-pointer"
                                            onclick="delete_alert({{ $post->id }})" />
                                    @endrole
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $posts->links() }}
            @if (count($posts) === 0)
                <p class="text-center">No se encontraron registros</p>
            @endif
        </div>

    </div>
</div>
