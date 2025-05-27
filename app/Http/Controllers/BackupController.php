<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Schedule;

class BackupController extends Controller
{

    public function databaseBackup()
    {
        $files = Storage::files('backup');
        return view('admin.settings.dabase_backup', compact('files'));
    }

    public function downloadBackup($filename)
    {
        // The file should be in storage/app/backup/
        $filePath = 'backup/' . $filename;

        if (!Storage::exists($filePath)) {
            abort(404, "File not found: " . $filename);
        }

        return Storage::download($filePath);
    }

    public function removeBackup($filename)
    {
        try {
            $filePath = 'backup/' . $filename; // Note: 'backups' not 'backup'

            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
                return redirect()->back()->with('success', 'Backup file deleted successfully');
            }

            return redirect()->back()->with('error', 'File not found');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting file: ' . $e->getMessage());
        }
    }
}
