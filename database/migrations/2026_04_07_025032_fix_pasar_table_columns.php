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
        Schema::table('pasar', function (Blueprint $table) {
            // Menambah kolom yang dibutuhkan
            $table->text('alamat')->nullable()->after('nama_pasar');
            $table->text('keterangan')->nullable()->after('alamat');
            
            // Menghapus kolom lama yang tidak sesuai
            if (Schema::hasColumn('pasar', 'lokasi')) {
                $table->dropColumn('lokasi');
            }
            if (Schema::hasColumn('pasar', 'tipe_kriteria')) {
                $table->dropColumn('tipe_kriteria');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasar', function (Blueprint $table) {
            //
        });
    }
};
