<?php

namespace App\Livewire;

use App\Models\Binnacle;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class Backup extends Component
{
    use WithPagination;

    protected $dump_path;
    protected $destination_path;
    protected $listeners = ['save', 'download'];

    public function get_size($size)
    {
        $units = [
            'GB' => 1 << 30,
            'MB' => 1 << 20,
            'KB' => 1 << 10,
        ];

        foreach ($units as $unit => $value) {
            if ($size >= $value) {
                return number_format($size / $value, 2) . $unit;
            }
        }

        return number_format($size, 2) . " B";
    }

    public function save()
    {
        $file_name = Carbon::now()->format('Y-m-d-H-i-s');

        $this->dump_path = config('custom_backup.dump_path');
        $this->destination_path = config('custom_backup.destination_path');

        File::ensureDirectoryExists($this->destination_path);
        $db_name = env('DB_DATABASE');
        shell_exec("$this->dump_path -h localhost -u root $db_name > $this->destination_path/$file_name.sql 2>&1");

        Binnacle::create([
            'user_id' => auth()->id(),
            'status' => 'info',
            'message' => "Se guardó un respaldo de la base de datos"
        ]);
    }

    public function download($record)
    {
        $file_name = $record;
        $disk = Storage::disk('backups');

        $this->dump_path = config('custom_backup.dump_path');
        $this->destination_path = config('custom_backup.destination_path');

        if ($disk->exists($file_name)) {
            $stream = $disk->readStream($file_name);
            $download_file_name = explode('/', $file_name)[1];

            Binnacle::create([
                'user_id' => auth()->id(),
                'status' => 'info',
                'message' => "Se descargó un respaldo de la base de datos"
            ]);

            return Response::stream(function () use ($stream) {
                fpassthru($stream);
                fclose($stream);
            }, 200, [
                'Content-Type' => $disk->mimeType($file_name),
                'Content-Length' => $disk->size($file_name),
                'Content-disposition' => "attachment; filename={$download_file_name}",
            ]);
        } else {
            return 'El respaldo que intenta descargar no existe, pruebe creando una copia de seguridad u otro respaldo';
        }
    }

    public function mount()
    {
        if (auth()->user()->hasRole('client')) {
            return redirect()->route('home');
        }
        if (auth()->user()->hasRole('employee')) {
            return redirect()->route('dashboard');
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $disk = Storage::disk('backups');
        $files = $disk->files('/backups');

        // Create a collection from the files
        $backups = collect($files)->map(function ($file) use ($disk) {
            $data = explode('/', $file);
            $date = explode('.', $data[1])[0];

            return [
                'key' => $file,
                'date' => Carbon::createFromFormat('Y-m-d-H-i-s', $date)->format('d/m/Y - h:i a'),
                'size' => $this->get_size($disk->size($file))
            ];
        })->reverse();

        $perPage = 10;
        $currentPage = Paginator::resolveCurrentPage();
        $currentItems = $backups->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $paginatedBackups = new LengthAwarePaginator($currentItems, $backups->count(), $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath(),
            'query' => request()->query(),
        ]);

        return view('livewire.backup', [
            'backups' => $paginatedBackups,
            'title' => 'Respaldo'
        ]);
    }
}
