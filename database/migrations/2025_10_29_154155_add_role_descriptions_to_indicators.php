<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('indicators', function (Blueprint $table) {
            $table->text('description_school')->nullable()->after('description');
            $table->text('description_home')->nullable()->after('description_school');
        });
    }

    public function down(): void {
        Schema::table('indicators', function (Blueprint $table) {
            $table->dropColumn(['description_school', 'description_home']);
        });
    }
};