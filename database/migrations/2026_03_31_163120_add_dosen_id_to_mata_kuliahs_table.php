// database/migrations/xxxx_add_dosen_id_to_mata_kuliahs_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->foreignId('dosen_id')
                ->nullable()
                ->after('id')
                ->constrained('dosens')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Dosen::class);
            $table->dropColumn('dosen_id');
        });
    }
};