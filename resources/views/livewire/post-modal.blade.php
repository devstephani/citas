<div x-data="{ open: @entangle('showModal') }">
    <x-button wire:click="toggle" class="w-full sm:w-fit gap-3" title="Registrar publicación">
        <x-lucide-plus class="size-5" />
        Publicación
    </x-button>

    <x-modal id="service-modal" maxWidth="lg" wire:model.self="showModal">
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900">
                Nueva publicación
            </div>

            <div class="mt-4 text-sm text-gray-600">
                <article class="mb-4 flex flex-col gap-4">
                    <div class="block">
                        <x-label value="Nombre" for="title" />
                        <x-input placeholder="Ej: Tips para un mejor maquillaje" wire:model.lazy="title" type="text"
                            id="title" name="title" class="w-full" autofocus autocomplete="off" required />
                        <x-input-error for="title" class="mt-2" />
                    </div>

                    <div class="block">
                        <x-label value="Descripción" for="description" />
                        <x-textarea
                            placeholder="Ej: Hablaremos un poco sobre nuestros tips y consejos para tener un maquillaje espectacular"
                            wire:model.lazy="description" id="description" name="description" class="w-full"
                            required></x-textarea>
                        <x-input-error for="description" class="mt-2" />
                    </div>

                    <div class="block">
                        <x-label value="Imágen" for="image" />

                        <x-input type="file" wire:model="image" accept=".jpg" />

                        <x-input-error for="image" class="mt-2" />
                        @if (($image && $id < 1) || ($image && $prevImg !== $image))
                            <img src="{{ $image->temporaryUrl() }}">
                        @endif
                        @if ($prevImg === $image && $id > 0)
                            <img src="{{ asset('storage/' . $image) }}">
                        @endif
                        <div wire:loading wire:target="image">
                            <p class="text-gray-600">Cargando imágen, por favor espere...</p>
                        </div>
                    </div>

                    <div class="block">
                        <x-label value="Contenido" for="message" />
                        <div wire:ignore>
                            <textarea id="message" wire:model.lazy="message"></textarea>
                        </div>
                    </div>

                    @if ($id > 0)
                        <div class="block">
                            <x-label value="Activo" for="active" />
                            <x-select wire:model.lazy="active" id="active" name="active" required class="w-full">
                                <option value="0">Inactivo</option>
                                <option value="1">Activo</option>
                            </x-select>
                            <x-input-error for="active" class="mt-2" />
                        </div>
                    @endif
                </article>

                @if ($id > 0)
                    <x-button wire:target="image" type="button" wire:click="update()" wire:loading.attr="disabled">
                        Actualizar
                    </x-button>
                @else
                    <x-button wire:target="image" type="button" wire:click="save()" wire:loading.attr="disabled">
                        Publicar
                    </x-button>
                @endif
                <x-button type="button" @click="show = false">
                    Cerrar
                </x-button>
            </div>
        </div>
    </x-modal>
</div>

@push('scripts')
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#message',
            plugins: 'lists',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist',
            setup: function(editor) {
                editor.on('init change', function() {
                        editor.save()
                    }),
                    editor.on('change', function(e) {
                        @this.set('message', editor.getContent())
                    })
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            Livewire.on('clean', function() {
                tinymce.get('message').setContent('')
            })
            Livewire.on('updateTinyMCE', function(data) {
                tinymce.get('message').setContent(data[0].content)
            })
        })
    </script>
@endpush
