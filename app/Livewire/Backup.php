<?php

namespace App\Livewire;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Backup extends Component
{
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
        try {
            Artisan::call('backup:run --only-db');
            $output = Artisan::output();

            dd($output);
            return 'La base de datos ha sido exportada correctamente';
        } catch (Exception $e) {
            return 'Hubo un error, por favor intente de nuevo';
        }
    }

    public function download($record)
    {
        $file_name = $record;
        $file = config('laravel-backup.backup.name') . $file_name;
        $disk = Storage::disk(config('laravel.backup.backup.destination.disks'));

        if ($disk->exists($file)) {
            $stream = $disk->readStream($file);

            $download_file = sprintf('Respaldo base de datos %s', basename($file));

            return Response::stream(function () use ($stream) {
                fpassthru($stream);
                fclose($stream);
            }, 200, [
                'Content-Type' => $disk->mimeType($file),
                'Content-Length' => $disk->size($file),
                'Content-disposition' => "attachment; filename={$download_file}",
            ]);
        } else {
            return 'El respaldo que intenta descargar no existe, pruebe creando una copia de seguridad u otro respaldo';
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $backups = [];
        $disk = Storage::disk(config('laravel.backup.backup.destination.disks'));
        $files = $disk->files('/Browslashes Stefy');

        foreach ($files as $key => $file) {
            $data = explode('/', $file);
            $date = explode('.', $data[1])[0];
            $backups[$key] = [
                'index' => ++$key,
                'name' => $data[0],
                'key' => $file,
                'date' => Carbon::createFromFormat('Y-m-d-H-i-s', $date)->format('d/m/Y - h:i a'),
                'size' => $this->get_size($disk->size($file))
            ];
        }

        return view('livewire.backup', [
            'backups' => $backups
        ]);
    }
}
