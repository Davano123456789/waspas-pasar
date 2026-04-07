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
        Schema::create('penilaian', function (Blueprint $table) {
            $table->increments('id_penilaian');
            $table->unsignedInteger('id_pengguna');
            $table->unsignedInteger('id_pasar');
            $table->unsignedInteger('id_kriteria');
            $table->float('nilai');
            $table->timestamps();

            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
            $table->foreign('id_pasar')->references('id_pasar')->on('pasar')->onDelete('cascade');
            $table->foreign('id_kriteria')->references('id_kriteria')->on('kriteria')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};
