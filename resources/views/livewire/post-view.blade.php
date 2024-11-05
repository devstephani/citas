<div>
    <section class="mt-16 mx-auto max-w-[70ch]">
        <div class="flex flex-col gap-3">
            <div class="flex justify-between items-center">
                <div class="flex flex-col">
                    <h1 class="text-2xl">{{ $post->title }}</h1>
                    <span>Publicado {{ $post->created_at->diffForHumans() }}</span>
                    @if (Auth::user()->hasRole('admin'))
                        <div class="flex gap-3">
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
                    @endif
                </div>
                <a href="{{ Auth::user()->hasRole('admin') ? route('posts') : route('home') }}">
                    <x-button type="button" class="w-fit">
                        <x-lucide-arrow-left class="size-5" />
                        Volver
                    </x-button>
                </a>
            </div>

            @if (!Auth::user()->hasRole('admin'))
                <div class="flex gap-3">
                    <x-button type="button" wire:click="dispatch('toggle_rate', { rate: 1 })"
                        class="bg-transparent border focus:ring-0 border-neutral-400 !rounded-full">
                        <x-lucide-thumbs-up @class([
                            'size-5',
                            'text-black' => $my_rate === null || $my_rate === 0,
                            'text-blue-600' => $my_rate === 1,
                        ]) />
                    </x-button>
                    <x-button type="button" wire:click="dispatch('toggle_rate', { rate: 0 })"
                        class="bg-transparent border focus:ring-0 border-neutral-400 !rounded-full">
                        <x-lucide-thumbs-down @class([
                            'size-5',
                            'text-black' => $my_rate === null || $my_rate === 1,
                            'text-red-600' => $my_rate === 0,
                        ]) />
                    </x-button>
                </div>
            @endif
        </div>

        <div class="mt-4 mb-8 max-w-[70ch] text-wrap break-words">
            <p class="text-justify mb-5">{{ $post->description }}</p>
            {!! $post->content !!}
        </div>

        <article class="mb-4 flex flex-col">
            @if (!Auth::check())
                <p class="text-gray-600"><a href="{{ route('login') }}" class="text-blue-600">Inicie sesión</a> para
                    comentar...</p>
            @else
                <h4 class="text-xl">Comentarios ({{ count($post->comments) }})</h4>
                <ul class="flex flex-col">
                    @foreach ($post->comments as $comment)
                        <li wire:key="{{ $comment->id }}"
                            class="flex flex-col border border-neutral-400 rounded-sm p-4 bg-white/70">
                            <div class="flex justify-between">
                                <h6>{{ $comment->user->name }}</h6>

                                @if (Auth::user()->hasRole('admin'))
                                    <div class="flex gap-3">
                                        <x-lucide-trash class="size-4 cursor-pointer hover:text-blue-600"
                                            onclick="delete_alert({{ $comment->id }})" />
                                        @if ($comment->active)
                                            <x-lucide-circle-check
                                                wire:click="$dispatch('toggle_comment_active', { record: {{ $comment->id }} })"
                                                class="cursor-pointer size-5 text-green-700" />
                                        @else
                                            <x-lucide-circle-slash
                                                wire:click="$dispatch('toggle_comment_active', { record: {{ $comment->id }} })"
                                                class="cursor-pointer size-5 text-red-700" />
                                        @endif
                                    </div>
                                @endif

                                @if ($comment->id === $comment_id)
                                    <div class="flex gap-3">
                                        <x-lucide-pencil class="size-4 cursor-pointer hover:text-blue-600"
                                            wire:click="toggle_edit_comment()" />
                                        <x-lucide-trash class="size-4 cursor-pointer hover:text-blue-600"
                                            onclick="delete_alert({{ $comment->id }})" />
                                    </div>
                                @endif
                            </div>
                            <small>{{ $comment->created_at->diffForHumans() }}</small>

                            <p class="mt-1">{{ $comment->content }}</p>
                        </li>
                    @endforeach
                </ul>
                @if (!Auth::user()->hasRole('admin') && ($first_comment || $can_comment))
                    <div class="mt-5 block">
                        <x-label value="Comentario" for="comment" />
                        <x-textarea wire:model.lazy="comment" id="comment" name="comment" class="w-full"
                            required></x-textarea>
                        <x-button type="button" wire:click="save_comment()">Enviar</x-button>
                        @if ($can_comment)
                            <x-button type="button" wire:click="toggle_edit_comment()">Cancelar</x-button>
                        @endif
                    </div>
                @endif
            @endif
        </article>
    </section>
</div>
