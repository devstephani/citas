<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Employee;
use App\Models\Package;
use App\Models\Post;
use App\Models\Service;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class DeletedRecords extends Component
{
    use WithPagination;
    private $pagination = 20;
    protected $listeners = ['refreshParent' => '$refresh', 'recover'];

    public function recover($record, $model)
    {
        switch ($model) {
            case 'Cliente':
                User::withTrashed()
                    ->find($record)->restore();
                break;
            case 'Empleado':
                Employee::withTrashed()
                    ->find($record)->restore();
                break;
            case 'Servicio':
                Service::withTrashed()
                    ->find($record)->restore();
                break;
            case 'Paquete':
                Package::withTrashed()
                    ->find($record)->restore();
                break;
            case 'Publicación':
                Post::withTrashed()
                    ->find($record)->restore();
                break;
            case 'Comentario':
                Comment::withTrashed()
                    ->find($record)->restore();
                break;

            default:
                # code...
                break;
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $data = [];
        $clients = User::onlyTrashed()
            ->with('roles')
            ->whereHas('roles', function ($q) {
                $q->whereIn('name', ['client']);
            })
            ->orderByDesc('created_at')
            ->get();
        $employees = Employee::onlyTrashed()
            ->orderByDesc('created_at')
            ->get();
        $services = Service::onlyTrashed()
            ->orderByDesc('created_at')
            ->get();
        $packages = Package::onlyTrashed()
            ->orderByDesc('created_at')
            ->get();
        $posts = Post::onlyTrashed()
            ->orderByDesc('created_at')
            ->get();
        $comments = Comment::onlyTrashed()
            ->orderByDesc('created_at')
            ->get();

        foreach ($clients as $client) {
            $data[] = ['id' => $client->id, 'model' => 'Cliente', 'title' => $client->name, 'deleted_at' => $client->deleted_at];
        }
        foreach ($employees as $employee) {
            $data[] = ['id' => $employee->id, 'model' => 'Empleado', 'title' => $employee->user->name, 'deleted_at' => $employee->deleted_at];
        }
        foreach ($services as $service) {
            $data[] = ['id' => $service->id, 'model' => 'Servicio', 'title' => $service->name, 'deleted_at' => $service->deleted_at];
        }
        foreach ($packages as $package) {
            $data[] = ['id' => $package->id, 'model' => 'Paquete', 'title' => $package->name, 'deleted_at' => $package->deleted_at];
        }
        foreach ($posts as $post) {
            $data[] = ['id' => $post->id, 'model' => 'Publicación', 'title' => $post->title, 'deleted_at' => $post->deleted_at];
        }
        foreach ($comments as $comment) {
            $data[] = ['id' => $comment->id, 'model' => 'Comentario', 'title' => $comment->content, 'deleted_at' => $comment->deleted_at];
        }

        return view('livewire.deleted-records', [
            'records' => $data,
            'title' => 'Papelera'
        ]);
    }
}
