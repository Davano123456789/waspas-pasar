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
        Schema::create('sub_kriteria', function (Blueprint $table) {
            $table->increments('id_sub_kriteria');
            $table->unsignedInteger('id_kriteria');
            $table->string('nama_sub_kriteria');
            $table->integer('nilai_likert');
            $table->timestamps();

            $table->foreign('id_kriteria')->references('id_kriteria')->on('kriteria')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_kriteria');
    }
};
