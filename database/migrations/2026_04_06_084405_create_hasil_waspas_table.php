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
        Schema::create('hasil_waspas', function (Blueprint $table) {
            $table->increments('id_hasil_waspas');
            $table->unsignedInteger('id_pasar');
            $table->unsignedInteger('id_pengguna');
            $table->float('skor_wsm');
            $table->float('skor_wpm');
            $table->float('skor_total_qi');
            $table->integer('rangking');
            $table->timestamps();

            $table->foreign('id_pasar')->references('id_pasar')->on('pasar')->onDelete('cascade');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_waspas');
    }
};
