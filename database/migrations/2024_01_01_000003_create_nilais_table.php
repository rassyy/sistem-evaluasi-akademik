<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mata_kuliah_id')->constrained('mata_kuliahs')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->onDelete('cascade');
            $table->decimal('rata_rata_tugas', 5, 2)->default(0);
            $table->decimal('nilai_uts', 5, 2)->default(0);
            $table->decimal('nilai_uas', 5, 2)->default(0);
            $table->decimal('bobot_tugas', 5, 2)->default(30.00);
            $table->decimal('bobot_uts', 5, 2)->default(30.00);
            $table->decimal('bobot_uas', 5, 2)->default(40.00);
            $table->decimal('nilai_akhir', 5, 2)->default(0);
            $table->string('nilai_huruf', 2)->default('E');
            $table->string('semester', 20)->nullable();
            $table->string('tahun_ajaran', 10)->nullable();
            $table->timestamps();

            $table->unique(['mata_kuliah_id', 'mahasiswa_id', 'semester', 'tahun_ajaran']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};