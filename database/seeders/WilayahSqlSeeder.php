<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class WilayahSqlSeeder extends Seeder
{
    public function run(): void
    {
        $sqlPath = database_path('wilayah.sql');

        if (File::exists($sqlPath)) {
            DB::unprepared(File::get($sqlPath));
            $this->command->info('Data wilayah berhasil di-import dari SQL.');
        } else {
            $this->command->error('File SQL tidak ditemukan: ' . $sqlPath);
        }
    }
}
