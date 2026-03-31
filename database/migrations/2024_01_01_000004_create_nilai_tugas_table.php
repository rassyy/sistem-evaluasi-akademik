<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nilai_tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nilai_id')->constrained('nilais')->onDelete('cascade');
            $table->string('nama_tugas', 100)->nullable();
            $table->decimal('nilai', 5, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_tugas');
    }
};