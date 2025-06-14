<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel 'user' (disesuaikan dengan nama tabel user Anda)
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            // Foreign key ke tabel 'mobil' (disesuaikan dengan nama tabel mobil Anda)
            $table->foreignId('mobil_id')->constrained('mobil')->onDelete('cascade');
            $table->timestamps();

            // Memastikan kombinasi user_id dan mobil_id unik
            // Artinya, satu mobil hanya bisa difavoritkan sekali oleh satu user
            $table->unique(['user_id', 'mobil_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}