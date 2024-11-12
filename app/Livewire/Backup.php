<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Backup extends Component
{
    protected $dump_path = "C:/laragon/bin/mysql/mysql-8.0.30-winx64/bin/mysqldump";
    protected $destination_path = "C:/laragon/www/manicurista/storage/app/public/backups";
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

        File::ensureDirectoryExists($this->destination_path);
        shell_exec("$this->dump_path -h localhost -u root manicurista > $this->destination_path/$file_name.sql");
    }

    public function download($record)
    {
        $file_name = $record;
        $disk = Storage::disk('backups');

        if ($disk->exists($file_name)) {
            $stream = $disk->readStream($file_name);
            $download_file_name = explode('/', $file_name)[1];

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
        $backups = [];
        $disk = Storage::disk('backups');
        $files = $disk->files('/backups');

        foreach ($files as $key => $file) {
            $data = explode('/', $file);
            $date = explode('.', $data[1])[0];

            $backups[$key] = [
                'index' => ++$key,
                'key' => $file,
                'date' => Carbon::createFromFormat('Y-m-d-H-i-s', $date)->format('d/m/Y - h:i a'),
                'size' => $this->get_size($disk->size($file))
            ];
        }

        return view('livewire.backup', [
            'backups' => $backups,
            'title' => 'Respaldo'
        ]);
    }
}
