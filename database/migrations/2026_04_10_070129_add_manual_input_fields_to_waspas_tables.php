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
        // 1. Tambah tipe_input di kriteria
        Schema::table('kriteria', function (Blueprint $table) {
            $table->string('tipe_input')->default('pilihan')->after('tipe_kriteria'); // pilihan, manual
        });

        // 2. Tambah range nilai di sub_kriteria
        Schema::table('sub_kriteria', function (Blueprint $table) {
            $table->double('minimal_nilai')->nullable()->after('nilai_likert');
            $table->double('maksimal_nilai')->nullable()->after('minimal_nilai');
        });

        // 3. Tambah nilai_asli di penilaian
        Schema::table('penilaian', function (Blueprint $table) {
            $table->double('nilai_asli')->nullable()->after('nilai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kriteria', function (Blueprint $table) {
            $table->dropColumn('tipe_input');
        });

        Schema::table('sub_kriteria', function (Blueprint $table) {
            $table->dropColumn(['minimal_nilai', 'maksimal_nilai']);
        });

        Schema::table('penilaian', function (Blueprint $table) {
            $table->dropColumn('nilai_asli');
        });
    }
};
