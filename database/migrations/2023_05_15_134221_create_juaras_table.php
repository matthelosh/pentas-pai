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
        Schema::create('juaras', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('peserta_id', 15);
            $table->integer("lomba_id");
            $table->string('bidang_id', 4);
            $table->string('peringkat', 2);
            $table->string('nilai', 3);
            $table->string('keterangan', 191);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('juaras');
    }
};
