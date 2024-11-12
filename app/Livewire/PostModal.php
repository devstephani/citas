<?php

namespace App\Livewire;

use App\Models\Post as MPost;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

class PostModal extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $message, $title, $active, $prevImg, $description;
    public $id = null;

    #[Validate('image|max:1024|mimetypes:image/jpg')]
    public $image;

    protected $listeners = ['edit', 'toggle', 'toggle_active', 'delete'];

    public function rules()
    {
        return [
            'title' => 'required|min:4|max:80|regex:/^[a-zA-Z\s]+$/',
            'description' => 'required|min:40|max:2000|regex:/^[a-zA-Z\s]+$/',
            'content' => 'required|min:10|max:150|regex:/^[a-zA-Z\s]+$/',
            'active' => ['boolean', Rule::excludeIf($this->id == null)],

        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Debe indicar el nombre',
            'title.regex' => 'Solo se aceptan letras',
            'title.min' => 'Debe contener al menos :min caracteres',
            'title.max' => 'Debe contener máximo :max caracteres',
            'description.required' => 'Debe indicar la descripción',
            'description.regex' => 'Solo se aceptan letras',
            'description.min' => 'Debe contener al menos :min caracteres',
            'description.max' => 'Debe contener máximo :max caracteres',
            'content.required' => 'Debe indicar la descripción',
            'content.regex' => 'Solo se aceptan letras',
            'content.min' => 'Debe contener al menos :min caracteres',
            'content.max' => 'Debe contener máximo :max caracteres',
            'email.required' => 'Debe indicar el correo',
            'email.email' => 'Debe ser un correo válido',
            'email.unique' => 'Este correo se encuentra registrado',
            'active.required' => 'Debe seleccionar alguna opción',
            'active.boolean' => 'La opción seleccionada debe ser "Si" o "No"',
        ];
    }

    public function save()
    {
        $this->validate();
        $path = $this->image->store('public/posts');

        MPost::create([
            'title' => $this->title,
            'content' => $this->message,
            'image' => $path,
            'description' => $this->description
        ]);

        $this->resetUI();
        $this->dispatch('clean', ['content' => '']);
    }

    public function toggle()
    {
        $this->resetUI();
        $this->showModal = ! $this->showModal;
    }


    public function edit(MPost $record)
    {
        $this->showModal = true;
        $this->id = $record->id;
        $this->title = $record->title;
        $this->message = $record->content;
        $this->active = $record->active;
        $this->description = $record->description;

        $this->dispatch('updateTinyMCE', ['content' => $this->message]);
    }

    public function update()
    {
        $this->validate();
        $post = MPost::find($this->id);

        if ($this->image !== $this->prevImg) {
            Storage::disk('public')->delete($post->image);
            $path = $this->image->store('public/posts');

            $post->update([
                'image' => $path,
            ]);
        }

        $post->update([
            'title' => $this->title,
            'content' => $this->message,
            'active' => $this->active,
            'description' => $this->description
        ]);

        $this->resetUI();
    }

    public function delete(MPost $record)
    {
        $record->delete();
        $this->resetUI();
    }

    public function toggle_active(MPost $record)
    {
        $record->update([
            'active' => ! $record->active
        ]);

        $this->dispatch('refreshParent')->to(Post::class);
    }

    public function resetUI()
    {
        $this->showModal = true;
        $this->id = '';
        $this->title = '';
        $this->message = '';
        $this->active = '';
        $this->image = '';
        $this->prevImg = '';
        $this->description = '';
        $this->showModal = false;
        $this->dispatch('refreshParent')->to(Post::class);
    }

    public function render()
    {
        return view('livewire.post-modal');
    }
}
