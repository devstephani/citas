<?php

return [
    'dump_path' => env('DB_DUMP_PATH', 'C:/xampp/mysql/bin/mysqldump'),
    'destination_path' => env('BACKUP_DESTINATION', 'C:/xampp/htdocs/Citas/storage/app/public/backups'),
    'db_name' => env('DB_DATABASE', 'sistema'),
    'app_name' => env('APP_NAME')
];
