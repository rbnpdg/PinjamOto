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
        Schema::create('mobil', function (Blueprint $table) {
            $table->id();
            $table->string('gambar')->nullable();
            $table->string('nama');
            $table->year('tahun');
            $table->enum('tipe', ['Mpv', 'SUV', 'Sedan','City car'])->nullable();
            $table->string('tnkb')->unique();
            $table->integer('kapasitas')->nullable();
            $table->enum('transmisi', ['Manual', 'Otomatis'])->nullable();
            $table->enum('bbm', ['Bensin', 'Diesel', 'Listrik'])->nullable();
            $table->decimal('hargasewa', 10);
            $table->enum('status', ['Tersedia', 'Disewa', 'Maintenance'])->default('Tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobil');
    }
};
