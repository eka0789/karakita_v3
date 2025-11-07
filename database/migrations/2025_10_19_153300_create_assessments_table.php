<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('assessor_id')->constrained('users')->onDelete('cascade');

            // ✅ tambahkan kolom source di sini
            $table->enum('source', ['pengajar', 'orangtua'])->default('pengajar');

            // ✅ kolom tambahan
            $table->string('class_name', 100)->nullable();
            $table->date('assessed_at');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
