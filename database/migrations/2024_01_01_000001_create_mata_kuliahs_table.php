<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mata_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_matakuliah', 20)->unique();
            $table->string('nama_matakuliah', 100);
            $table->integer('sks')->default(2);
            $table->decimal('bobot_tugas', 5, 2)->default(30.00);
            $table->decimal('bobot_uts', 5, 2)->default(30.00);
            $table->decimal('bobot_uas', 5, 2)->default(40.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mata_kuliahs');
    }
};