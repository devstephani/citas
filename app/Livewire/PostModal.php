<?php

namespace App\Livewire;

use App\Models\Post as MPost;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostModal extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $message, $title, $active, $prevImg;
    public $id = null;

    #[Validate('image|max:1024')]
    public $image;


    protected $listeners = ['edit', 'toggle', 'toggle_active', 'delete'];

    public function save()
    {
        $path = $this->image->store('public/posts');

        MPost::create([
            'title' => $this->title,
            'content' => $this->message,
            'image' => $path
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

        $this->dispatch('updateTinyMCE', ['content' => $this->message]);
    }

    public function update()
    {
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
        $this->showModal = false;
        $this->dispatch('refreshParent')->to(Post::class);
    }

    public function render()
    {
        return view('livewire.post-modal');
    }
}
