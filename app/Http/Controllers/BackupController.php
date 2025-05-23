<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


class BackupController extends Controller
{

    public function store()
    {
        ini_set('max_execution_time', 900);
        ini_set('memory_limit', '512M');
        set_time_limit(900); // 15 mins

        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host     = config('database.connections.mysql.host');

        $timestamp = now()->format('Y_m_d_H_i_s');
        $fileName = "backup_{$timestamp}.sql";
        $backupPath = storage_path('app/backups');
        $filePath = "{$backupPath}/{$fileName}";

        if (!File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
        }

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $mysqldump = 'B:\\Xamp_php_8.2\\mysql\\bin\\mysqldump.exe';
        } else {
            $mysqldump = 'mysqldump';
        }

        $command = [
            $mysqldump,
            '-h',
            $host,
            '-u',
            $username,
            "-p{$password}",
            $database
        ];

        $process = new Process($command);
        $process->setTimeout(900); // 15 minutes

        try {
            $process->run(function ($type, $buffer) use ($filePath) {
                file_put_contents($filePath, $buffer, FILE_APPEND);
            });
        } catch (\Exception $e) {
            return response()->json(['error' => 'Backup failed: ' . $e->getMessage()], 500);
        }

        if (!$process->isSuccessful()) {
            return response()->json(['error' => 'Backup process failed.'], 500);
        }

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
