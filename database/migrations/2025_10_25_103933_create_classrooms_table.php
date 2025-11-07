<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::create('classrooms', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique();
        $table->timestamps();
    });

    Schema::table('users', function (Blueprint $table) {
        $table->foreignId('classroom_id')
            ->nullable()
            ->constrained('classrooms')
            ->nullOnDelete();
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['classroom_id']);
        $table->dropColumn('classroom_id');
    });

    Schema::dropIfExists('classrooms');
}

};
