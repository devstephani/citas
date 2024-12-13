<?php

namespace App\Console\Commands;

use App\Models\Binnacle;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dump_path = config('custom_backup.dump_path');
        $destination_path = config('custom_backup.destination_path');

        $file_name = Carbon::now()->format('Y-m-d-H-i-s');

        File::ensureDirectoryExists($destination_path);
        $db_name = config('custom_backup.db_name');
        $output = shell_exec("$dump_path -h localhost -u root $db_name > $destination_path/$file_name.sql 2>&1");
        if ($output) {
            $this->info("Fallo al intentar hacer el respaldo de base de datos, error: $output");
            return;
        }

        $adminUser = User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->first();
        if (!$adminUser) {
            $this->info("No se encontró al usuario admin");
            return;
        }

        $this->info("Se realizó el respaldo de base de datos exitosamente");

        Binnacle::create([
            'user_id' => $adminUser->id,
            'status' => 'info',
            'message' => "Se realizó el respaldo automático de la base de datos"
        ]);
    }
}
