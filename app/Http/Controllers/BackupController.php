<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use PDO;
use RealRashid\SweetAlert\Facades\Alert;
use ZipArchive;

class BackupController extends Controller
{
    /**
     * Tampilkan halaman utama Backup Database & Storage.
     */
    public function index()
    {
        // 1. Informasi Database
        $databaseName = config('database.connections.mysql.database', 'sinergi');
        $tables = [];
        try {
            $tables = DB::select('SHOW TABLES');
        } catch (Exception $e) {
            Log::warning('Gagal mengambil daftar tabel: ' . $e->getMessage());
        }
        $totalTables = count($tables);

        // 2. Informasi Storage Public
        $storagePath = storage_path('app/public');
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true);
        }

        $storageFiles = File::allFiles($storagePath);
        $totalStorageFiles = count($storageFiles);
        $totalStorageBytes = 0;

        foreach ($storageFiles as $file) {
            $totalStorageBytes += $file->getSize();
        }

        $totalStorageSizeFormatted = $this->formatBytes($totalStorageBytes);

        return view('pages.backup.index', compact(
            'databaseName',
            'totalTables',
            'totalStorageFiles',
            'totalStorageSizeFormatted'
        ));
    }

    /**
     * Unduh file SQL dump database.
     */
    public function downloadDatabase()
    {
        try {
            $databaseName = config('database.connections.mysql.database', 'sinergi');
            $fileName = 'backup-database-' . $databaseName . '-' . date('Y-m-d-His') . '.sql';

            $sqlContent = "-- =====================================================\n";
            $sqlContent .= "-- SINERGI PLD Database Backup\n";
            $sqlContent .= "-- Database: " . $databaseName . "\n";
            $sqlContent .= "-- Tanggal: " . date('Y-m-d H:i:s') . "\n";
            $sqlContent .= "-- Laravel Version: " . app()->version() . "\n";
            $sqlContent .= "-- PHP Version: " . PHP_VERSION . "\n";
            $sqlContent .= "-- =====================================================\n\n";
            $sqlContent .= "SET FOREIGN_KEY_CHECKS=0;\n";
            $sqlContent .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
            $sqlContent .= "SET time_zone = \"+00:00\";\n\n";

            $tables = DB::select('SHOW FULL TABLES WHERE Table_Type = "BASE TABLE"');

            foreach ($tables as $tableObj) {
                $tableProp = 'Tables_in_' . $databaseName;
                $tableName = isset($tableObj->$tableProp) ? $tableObj->$tableProp : array_values((array) $tableObj)[0];

                // Drop table if exists & Create table structure
                $sqlContent .= "-- -----------------------------------------------------\n";
                $sqlContent .= "-- Struktur tabel `$tableName`\n";
                $sqlContent .= "-- -----------------------------------------------------\n";
                $sqlContent .= "DROP TABLE IF EXISTS `$tableName`;\n";

                $createTable = DB::select("SHOW CREATE TABLE `$tableName`");
                $createProp = 'Create Table';
                $createSql = isset($createTable[0]->$createProp) ? $createTable[0]->$createProp : array_values((array) $createTable[0])[1];
                $sqlContent .= $createSql . ";\n\n";

                // Data tabel
                $rows = DB::table($tableName)->get();
                if ($rows->count() > 0) {
                    $sqlContent .= "-- Data untuk tabel `$tableName` (" . $rows->count() . " baris)\n";
                    $columns = array_keys((array) $rows->first());
                    $escapedColumns = array_map(function ($col) {
                        return "`" . str_replace("`", "``", $col) . "`";
                    }, $columns);

                    $sqlContent .= "INSERT INTO `$tableName` (" . implode(', ', $escapedColumns) . ") VALUES\n";

                    $valueRows = [];
                    foreach ($rows as $row) {
                        $values = [];
                        foreach ((array) $row as $val) {
                            if (is_null($val)) {
                                $values[] = 'NULL';
                            } elseif (is_numeric($val) && !is_string($val)) {
                                $values[] = $val;
                            } else {
                                $values[] = "'" . addslashes((string) $val) . "'";
                            }
                        }
                        $valueRows[] = "(" . implode(', ', $values) . ")";
                    }

                    // Gabungkan baris-baris INSERT
                    $sqlContent .= implode(",\n", $valueRows) . ";\n\n";
                }
            }

            $sqlContent .= "SET FOREIGN_KEY_CHECKS=1;\n";
            $sqlContent .= "-- Selesai diekspor pada: " . date('Y-m-d H:i:s') . "\n";

            return response($sqlContent, 200, [
                'Content-Type' => 'application/sql',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]);
        } catch (Exception $e) {
            Log::error('Gagal mencadangkan database: ' . $e->getMessage());
            Alert::error('Gagal', 'Terjadi kesalahan saat mengekspor database: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Pulihkan / Import database dari file SQL yang diunggah.
     */
    public function restoreDatabase(Request $request)
    {
        $request->validate([
            'sql_file' => 'required|file|max:102400', // max 100MB
        ], [
            'sql_file.required' => 'Pilih berkas SQL backup terlebih dahulu.',
            'sql_file.file' => 'Berkas tidak valid.',
            'sql_file.max' => 'Ukuran berkas SQL maksimal 100MB.',
        ]);

        $file = $request->file('sql_file');
        $extension = strtolower($file->getClientOriginalExtension());

        if (!in_array($extension, ['sql', 'txt'])) {
            Alert::error('Gagal', 'Format file harus berupa .sql');
            return redirect()->back();
        }

        try {
            $sql = File::get($file->getRealPath());

            $pdo = DB::connection()->getPdo();
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

            $wrappedSql = "SET FOREIGN_KEY_CHECKS=0;\n" . $sql . "\nSET FOREIGN_KEY_CHECKS=1;";
            $pdo->exec($wrappedSql);

            // Bersihkan koneksi agar buffer statement di-reset
            DB::purge();
            DB::reconnect();

            Alert::success('Berhasil', 'Database berhasil dipulihkan dari berkas backup!');
            return redirect()->route('backup.index');
        } catch (Exception $e) {
            Log::error('Gagal memulihkan database: ' . $e->getMessage());
            try {
                DB::purge();
                DB::reconnect();
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            } catch (Exception $ignored) {
            }
            Alert::error('Gagal Memulihkan', 'Terjadi kesalahan saat memulihkan database: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Unduh file ZIP backup dari folder storage/app/public.
     */
    public function downloadStorage()
    {
        $storagePath = storage_path('app/public');

        if (!File::exists($storagePath) || count(File::allFiles($storagePath)) === 0) {
            Alert::warning('Perhatian', 'Tidak ada berkas di dalam storage public untuk dicadangkan.');
            return redirect()->back();
        }

        $zipFileName = 'backup-storage-sinergi-' . date('Y-m-d-His') . '.zip';
        $tempDir = storage_path('app/temp-backups');
        if (!File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0755, true);
        }

        $zipPath = $tempDir . DIRECTORY_SEPARATOR . $zipFileName;

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $files = File::allFiles($storagePath);

            foreach ($files as $file) {
                $relativePath = substr($file->getRealPath(), strlen($storagePath) + 1);
                $zip->addFile($file->getRealPath(), $relativePath);
            }

            $zip->close();

            return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
        }

        Alert::error('Gagal', 'Tidak dapat membuat berkas arsip ZIP.');
        return redirect()->back();
    }

    /**
     * Pulihkan / Import storage dari file ZIP yang diunggah.
     */
    public function restoreStorage(Request $request)
    {
        $request->validate([
            'zip_file' => 'required|file|max:204800', // max 200MB
        ], [
            'zip_file.required' => 'Pilih berkas ZIP backup storage terlebih dahulu.',
            'zip_file.file' => 'Berkas tidak valid.',
            'zip_file.max' => 'Ukuran berkas ZIP maksimal 200MB.',
        ]);

        $file = $request->file('zip_file');
        $extension = strtolower($file->getClientOriginalExtension());

        if ($extension !== 'zip') {
            Alert::error('Gagal', 'Format berkas harus berupa .zip');
            return redirect()->back();
        }

        $storagePath = storage_path('app/public');
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true);
        }

        $zip = new ZipArchive();
        if ($zip->open($file->getRealPath()) === true) {
            $zip->extractTo($storagePath);
            $zip->close();

            Alert::success('Berhasil', 'Berkas storage public berhasil dipulihkan!');
            return redirect()->route('backup.index');
        }

        Alert::error('Gagal', 'Tidak dapat mengekstrak berkas ZIP backup.');
        return redirect()->back();
    }

    /**
     * Format byte menjadi satuan yang mudah dibaca (KB, MB, GB).
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
