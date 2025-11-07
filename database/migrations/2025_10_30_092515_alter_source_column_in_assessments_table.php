<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            // ubah kolom source menjadi string agar fleksibel
            $table->string('source', 50)->default('manual')->change();
        });
    }

    public function down(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            // rollback ke enum lama (jika perlu)
            $table->enum('source', ['manual', 'ai'])->default('manual')->change();
        });
    }
};
