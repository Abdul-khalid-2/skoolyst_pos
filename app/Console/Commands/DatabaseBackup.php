<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:database-backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a database backup';



    public function handle()
    {
        // Ensure backup directory exists
        $backupDir = Storage::path('backup');
        if (!file_exists($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $filename = now()->format("d-m-y-H-i-s") . ".sql";
        $path = Storage::path("backup/" . $filename);

        // Determine the correct mysqldump path based on environment
        $mysqldumpPath = $this->getMysqldumpPath();

        $command = sprintf(
            '%s --user=%s --password=%s --host=%s %s > %s',
            $mysqldumpPath,
            escapeshellarg(env('DB_USERNAME')),
            escapeshellarg(env('DB_PASSWORD')),
            escapeshellarg(env('DB_HOST')),
            escapeshellarg(env('DB_DATABASE')),
            escapeshellarg($path)
        );

        $process = Process::run($command);

        if ($process->successful()) {
            $this->info("Database backup saved as: " . $filename);
        } else {
            $this->error("Backup failed. Error: " . $process->errorOutput());
        }
    }

    protected function getMysqldumpPath()
    {
        // For Windows (local development)
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return '"B:\Xamp_php_8.2\mysql\bin\mysqldump.exe"';
        }

        // For Linux/Unix (production)
        // First try to find mysqldump in common locations
        $commonPaths = [
            '/usr/bin/mysqldump',
            '/usr/local/bin/mysqldump',
            '/usr/mysql/bin/mysqldump',
        ];

        foreach ($commonPaths as $path) {
            if (file_exists($path)) {
                return escapeshellarg($path);
            }
        }

        // Fallback to just 'mysqldump' (relying on PATH)
        return 'mysqldump';
    }
}
