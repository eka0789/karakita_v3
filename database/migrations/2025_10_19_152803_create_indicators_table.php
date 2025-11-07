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
        Schema::create('indicators', function (Blueprint $table) {
    $table->id();
    $table->foreignId('peace_value_id')->constrained()->cascadeOnDelete();
    $table->string('name'); // ✅ Kolom judul indikator (Wajib)
    $table->text('description')->nullable(); // ✅ Ubah jadi opsional & text
    $table->tinyInteger('scale_min')->default(1);
    $table->tinyInteger('scale_max')->default(5);
    $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicators');
    }
};
