<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProjectHealthCheck extends Command
{
    protected $signature = 'project:health';
    protected $description = 'Full read-only project performance and health check';

    public function handle()
    {
        $this->info("🔍 Starting Project Health Check...\n");

        $this->checkDatabaseQueries();
        $this->checkStorageSize();
        $this->checkPublicUploads();
        $this->checkLargeFiles();
        $this->checkPotentialBottlenecks();

        $this->info("\n✅ Health check completed.");
    }

    // 🧠 1. فحص الاستعلامات الثقيلة (تقريب تقريبي)
    private function checkDatabaseQueries()
    {
        $this->info("📊 Checking database tables...");

        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];

            $count = DB::table($tableName)->count();

            if ($count > 10000) {
                $this->warn("⚠ Large table detected: $tableName ($count rows)");
            }
        }
    }

    // 📦 2. حجم التخزين
    private function checkStorageSize()
    {
        $path = storage_path('app');

        $size = $this->folderSize($path);

        $this->info("💾 Storage size: " . round($size / 1024 / 1024, 2) . " MB");

        if ($size > 500 * 1024 * 1024) {
            $this->warn("⚠ Storage is too large - may slow backup and disk I/O");
        }
    }

    // 📁 3. public uploads
    private function checkPublicUploads()
    {
        $path = public_path('uploads');

        if (!File::exists($path)) {
            $this->warn("Uploads folder not found");
            return;
        }

        $files = File::allFiles($path);

        $this->info("📁 Public uploads files: " . count($files));

        if (count($files) > 5000) {
            $this->warn("⚠ Too many files in uploads - may slow file system");
        }
    }

    // 🐘 4. ملفات كبيرة
    private function checkLargeFiles()
    {
        $this->info("📦 Checking large files...");

        $files = File::allFiles(public_path('uploads'));

        foreach ($files as $file) {
            $sizeMB = $file->getSize() / 1024 / 1024;

            if ($sizeMB > 5) {
                $this->warn("⚠ Large file: " . $file->getFilename() . " ({$sizeMB} MB)");
            }
        }
    }

    // ⚡ 5. مشاكل محتملة بالأداء
    private function checkPotentialBottlenecks()
    {
        $this->info("⚡ Checking performance risks...");

        $logPath = storage_path('logs');

        if (File::exists($logPath)) {
            $logSize = $this->folderSize($logPath);

            if ($logSize > 200 * 1024 * 1024) {
                $this->warn("⚠ Logs too large - can slow disk I/O");
            }
        }

        $this->info("✔ Basic performance scan done");
    }

    // 📏 حساب حجم مجلد
    private function folderSize($dir)
    {
        $size = 0;

        foreach (File::allFiles($dir) as $file) {
            $size += $file->getSize();
        }

        return $size;
    }
}
