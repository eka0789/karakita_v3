<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();

            // Relasi ke siswa (User)
            $table->foreignId('student_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Relasi ke peace value / indikator nilai karakter
            $table->foreignId('peace_value_id')
                ->nullable()
                ->constrained('peace_values')
                ->onDelete('set null');

            // Level urgensi (1–5)
            $table->unsignedTinyInteger('level')
                ->default(1)
                ->comment('Semakin tinggi berarti semakin prioritas');

            // Deskripsi rekomendasi
            $table->text('description')->nullable();

            // Sumber rekomendasi (manual / ai)
            $table->string('source', 50)->nullable()->default('manual');

            // Status aktif / sudah diterapkan
            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendations');
    }
};
