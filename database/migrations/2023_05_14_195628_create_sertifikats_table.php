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
        Schema::create('sertifikats', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('penerima', 100);
            $table->string('predikat', 100);
            $table->enum('tipe', ['juara', 'partisipasi', 'panitia']);
            $table->text('kegiatan', 100);
            $table->string('tempat', 60);
            $table->date('tanggal');
            $table->string('panitia', 60);
            $table->string('nip_panitia', 30)->nullable();
            $table->string('pejabat', 60)->nullable();
            $table->string('nip_pejabat', 60)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikats');
    }
};
