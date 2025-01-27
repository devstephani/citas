<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use App\Rules\Text;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PostView extends Component
{
    public $post, $my_rate, $user_id, $comment, $comment_id, $first_comment, $can_comment;
    protected $listeners = ['toggle_rate', 'delete', 'toggle_comment_active', 'update_comment', 'mark_favorite'];

    public function rules()
    {
        return [
            'comment' => ['required', 'min:3', 'max:200', new Text()]
        ];
    }

    public function messages()
    {
        return [
            'comment.required' => 'Debe añadir un comentario',
            'comment.regex' => 'Solo se aceptan letras',
            'comment.min' => 'Debe contener al menos :min caracteres',
            'comment.max' => 'Debe contener máximo :max caracteres',
        ];
    }

    public function mount($id)
    {
        $this->post = Post::find($id);
        if (empty($this->post)) {
            return redirect()->route('home');
        }

        $this->user_id = Auth::user()->id ?? 0;
        $this->comment_id = $this->post->comments()->where('user_id', $this->user_id ?? 0)->first()->id ?? 0;
        $this->first_comment = $this->comment_id <= 0;
        $this->can_comment = false;

        if (Auth::user()->hasRole('admin')) {
            $this->post->comments = $this->post->comments()->get();
        } else {
            $this->post->comments = $this->post->comments()->where('active', 1)->get();
        }
    }

    public function toggle_rate(int $rate)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $postReaction = $this->post
            ->reactions()
            ->where('user_id', $this->user_id)
            ->first();

        if ($postReaction) {
            $postReaction->update(['rate' => $rate]);
        } else {
            $this->post->reactions()->create([
                'user_id' => $this->user_id,
                'rate' => $rate,
            ]);
        }
    }

    public function save_comment()
    {
        $this->validate();
        $this->comment_id = $this->post->comments()->create([
            'user_id' => $this->user_id,
            'content' => $this->comment
        ]);

        $this->can_comment = false;
        $this->first_comment = false;
        $this->comment = '';
    }

    public function update_comment()
    {
        $record = Comment::find($this->comment_id);
        $this->validate();
        $record->update([
            'content' => $this->comment
        ]);

        $this->can_comment = false;
        $this->first_comment = false;
        $this->comment = '';
    }

    public function toggle_edit_comment()
    {
        if ($this->can_comment) {
            $this->can_comment = false;
            $this->comment = '';
        } else {
            $this->can_comment = true;
            $this->comment = Comment::find($this->comment_id)->content;
        }
    }

    public function toggle_comment_active(Comment $record)
    {
        $record->update([
            'active' => ! $record->active
        ]);
    }

    public function delete(Comment $record)
    {
        $record->delete();
        $this->can_comment = true;
        $this->first_comment = true;
    }

    public function mark_favorite()
    {
        $exist = $this->post->favorites()->where('user_id', $this->user_id)->first();

        if ($exist) {
            $exist->delete();
        } else {
            $this->post->favorites()->create([
                'user_id' => $this->user_id,
            ]);
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $this->user_id = Auth::user()->id ?? 0;
        $postReaction = $this->post
            ->reactions()
            ->where('user_id', $this->user_id ?? 0)
            ->first();
        $this->my_rate = $postReaction->rate ?? null;

        return view('livewire.post-view');
    }
}
