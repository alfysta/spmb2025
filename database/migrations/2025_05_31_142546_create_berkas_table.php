<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('berkas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('kartu_keluarga')->nullable();
            $table->string('ijazah')->nullable();
            $table->string('akte_kelahiran')->nullable();
            $table->string('ktp_ortu')->nullable();
            $table->string('sptjm')->nullable();
            $table->string('rapor')->nullable();
            $table->decimal('nilai_rapor1')->nullable();
            $table->decimal('nilai_rapor2')->nullable();
            $table->decimal('nilai_rapor3')->nullable();
            $table->decimal('nilai_rapor4')->nullable();
            $table->decimal('nilai_rapor5')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berkas');
    }
};
