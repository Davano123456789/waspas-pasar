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
        Schema::table('kriteria', function (Blueprint $table) {
            $table->dropColumn(['tipe_input', 'satuan']);
        });

        Schema::table('sub_kriteria', function (Blueprint $table) {
            $table->dropColumn(['minimal_nilai', 'maksimal_nilai']);
        });

        Schema::table('penilaian', function (Blueprint $table) {
            $table->dropColumn('nilai_asli');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kriteria', function (Blueprint $table) {
            $table->string('tipe_input')->default('pilihan')->after('tipe_kriteria');
            $table->string('satuan')->nullable()->after('tipe_input');
        });

        Schema::table('sub_kriteria', function (Blueprint $table) {
            $table->double('minimal_nilai')->nullable()->after('nilai_likert');
            $table->double('maksimal_nilai')->nullable()->after('minimal_nilai');
        });

        Schema::table('penilaian', function (Blueprint $table) {
            $table->double('nilai_asli')->nullable()->after('nilai');
        });
    }
};
