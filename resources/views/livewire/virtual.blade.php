@section('page-title')
    Probador virtual
@endsection

<div>
    <div>
        @role('client')
            <x-page-title :title="$title" :subtitle="$subtitle" />
        @endrole

        @if ($show_alert)
            <div class="max-w-sm mx-auto text-justify">
                <x-alert>
                    {{ session('alert') }}
                </x-alert>
            </div>
        @endif

        <div x-data="{
            eyelashesX: @entangle('eyeslashes_position.x'),
            eyelashesY: @entangle('eyeslashes_position.y'),
            browslashesX: @entangle('browslashes_position.x'),
            browslashesY: @entangle('browslashes_position.y'),
        }" class="p-12 w-full mx-auto flex items-center">
            <div class="mx-auto flex gap-3">
                <div class="flex flex-col gap-4 w-full">
                    <section
                        class="mx-auto border rounded-md border-neutral-400 p-4 flex flex-col items-center relative">
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file"
                                class="flex flex-col items-center justify-center w-full h-28 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                            class="font-semibold">Haga clic para subir una imagen</span></p>
                                </div>
                                <input id="dropzone-file" type="file" class="hidden" wire:model="photo"
                                    accept="image/*" />
                            </label>
                        </div>

                        <div wire:loading wire:target="photo">
                            <p class="text-gray-600">Cargando imágen, por favor espere...</p>
                        </div>

                        @if ($photo)
                            <img src="{{ $photo->temporaryUrl() }}" alt="Uploaded Image" class="mx-auto size-96">
                        @else
                            <img src="{{ asset('img/templates/face.png') }}" alt="Default Face Image"
                                class="mx-auto size-96">
                        @endif

                        @if (!empty($selected_eyeslashes) && $selected_eyeslashes !== '')
                            <img src="{{ asset($selected_eyeslashes) }}" alt=""
                                class="mx-auto w-36 h-12 absolute z-10"
                                x-bind:style="'top: ' + eyelashesY + '%; left: ' + eyelashesX + '%;'">
                        @endif
                        @if (!empty($selected_browslashes) && $selected_browslashes !== '')
                            <img src="{{ asset($selected_browslashes) }}" alt=""
                                class="mx-auto w-36 h-12 absolute z-10"
                                x-bind:style="'top: ' + browslashesY + '%; left: ' + browslashesX + '%;'">
                        @endif
                    </section>
                    <div class="grid grid-cols-1 sm:grid-cols-2 mx-auto gap-3">
                        <x-button wire:click="$dispatch('toggle', { side: 'eyeslashes' })">
                            Pestañas
                        </x-button>
                        <x-button wire:click="$dispatch('toggle', { side: 'browslashes' })">
                            Cejas
                        </x-button>
                        <x-button wire:click="save" class="text-center">
                            Guardar
                        </x-button>
                        <x-button wire:click="resetUI" class="text-center">
                            Limpiar
                        </x-button>
                    </div>
                </div>
                @if ($show_template)
                    <section
                        class="w-full max-w-96 max-h-fit border rounded-md border-neutral-400 p-4 flex flex-col items-center flex-wrap">
                        <div class="flex flex-wrap gap-3">
                            @if ($eyeslashes)
                                @foreach ($eyeslashes_images as $img)
                                    <img src="{{ $img }}" alt=""
                                        wire:click="$dispatch('toggle_images', { image: '{{ $img }}', side: 'eyeslashes'})"
                                        @class([
                                            'size-16 p-2 cursor-pointer hover:border hover:border-blue-500 hover:scale-110',
                                            'shadow border border-blue-300' => $selected_eyeslashes === $img,
                                        ])>
                                @endforeach

                                <div class="flex justify-between gap-3">
                                    <div class="">
                                        <x-label value="Posición x" for="eyeslashesX" />
                                        <input type="range" wire:model.lazy="eyeslashes_position.x" min="0"
                                            max="100" id="eyeslashesX" class="w-full" />
                                    </div>
                                    <div class="">
                                        <x-label value="Posición y" for="eyeslashesY" />
                                        <input type="range" wire:model.lazy="eyeslashes_position.y" min="0"
                                            max="100" id="eyeslashesY" class="w-full" />
                                    </div>
                                </div>
                            @endif
                            @if ($browslashes)
                                @foreach ($browslashes_images as $img)
                                    <img src="{{ $img }}" alt=""
                                        wire:click="$dispatch('toggle_images', { image: '{{ $img }}', side: 'browslashes'})"
                                        @class([
                                            'size-16 p-2 cursor-pointer hover:border hover:border-blue-500 hover:scale-110',
                                            'shadow border border-blue-300' => $selected_browslashes === $img,
                                        ])>
                                @endforeach

                                <div class="flex justify-between gap-3">
                                    <div class="">
                                        <x-label value="Posición x" for="browslashes_x" />
                                        <input type="range" wire:model.lazy="browslashes_position.x" min="0"
                                            max="100" id="browslashes_x" class="w-full" />
                                    </div>
                                    <div class="">
                                        <x-label value="Posición y" for="browslashes_y" />
                                        <input type="range" wire:model.lazy="browslashes_position.y" min="0"
                                            max="100" id="browslashes_y" class="w-full" />
                                    </div>
                                </div>
                            @endif
                        </div>
                    </section>
                @endif
            </div>

        </div>
    </div>

    <style>
        .custom-file-upload {
            display: inline-block;
            padding: 10px 20px;
            cursor: pointer;
            background-color: #007BFF;
            /* Bootstrap primary color */
            color: white;
            border-radius: 5px;
            text-align: center;
        }

        .custom-file-upload input[type=file] {
            display: none;
        }
    </style>
</div>
