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
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 30)->nullable();
            $table->string('nama', 60);
            $table->enum('jk', ['Laki-laki','Perempuan']);
            $table->string('alamat', 191)->default('Malang');
            $table->string('hp', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('sekolah_id', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
