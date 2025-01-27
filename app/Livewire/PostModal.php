<?php

namespace App\Livewire;

use App\Models\Binnacle;
use App\Models\Post as MPost;
use App\Rules\Text;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

class PostModal extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $message, $title, $active, $prevImg, $description;
    public $id = null;
    public $image;

    protected $listeners = ['edit', 'toggle', 'toggle_active', 'delete'];

    public function rules()
    {
        return [
            'title' => ['required', 'min:4', 'max:80', new Text()],
            'description' => ['required', 'min:12', 'max:400', new Text()],
            'message' => 'required|min:10|max:2000',
            'active' => ['boolean', Rule::excludeIf($this->id == null)],
            'image'  => [
                'nullable',
                Rule::when(!is_string($this->image), 'required|image|max:1024|mimes:jpg')
            ],
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
            'message.required' => 'Debe indicar la descripción',
            'message.regex' => 'Solo se aceptan letras',
            'message.min' => 'Debe contener al menos :min caracteres',
            'message.max' => 'Debe contener máximo :max caracteres',
            'active.required' => 'Debe seleccionar alguna opción',
            'active.boolean' => 'La opción seleccionada debe ser "Si" o "No"',
            'image.required' => 'Debe añadir una imágen',
            'image.image' => 'Debe ser una imágen',
            'image.max' => 'Debe pesar máximo 1 MB',
            'image.mimes' => 'Debe tener formato JPG',
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
            'description' => $this->description,
            'user_id' => auth()->user()->id
        ]);

        Binnacle::create([
            'user_id' => auth()->id(),
            'status' => 'success',
            'message' => "Se registró la publicación {$this->title}"
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
        $this->image = $record->image;
        $this->prevImg = $record->image;
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

        Binnacle::create([
            'user_id' => auth()->id(),
            'status' => 'success',
            'message' => "Se actualizó la publicación {$post->title}"
        ]);

        $this->resetUI();
    }

    public function delete(MPost $record)
    {
        $record->delete();

        Binnacle::create([
            'user_id' => auth()->id(),
            'status' => 'warning',
            'message' => "Se eliminó la publicación {$record->title}"
        ]);
        $this->resetUI();
    }

    public function toggle_active(MPost $record)
    {
        $record->update([
            'active' => ! $record->active
        ]);

        $message = $record->active ? 'activó' : 'desactivó';
        Binnacle::create([
            'user_id' => auth()->id(),
            'status' => 'info',
            'message' => "Se {$message} la publicación {$record->title}"
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
