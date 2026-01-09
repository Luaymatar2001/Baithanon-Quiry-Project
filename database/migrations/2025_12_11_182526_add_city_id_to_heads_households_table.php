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
        Schema::table('heads_households', function (Blueprint $table) {
            Schema::table('heads_households', function (Blueprint $table) {
                $table->foreignId('cityId')
                    ->nullable()
                    ->constrained('city')
                    ->nullOnDelete();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('heads_households', function (Blueprint $table) {
            $table->dropForeign(['cityId']);
            $table->dropColumn('cityId');
        });
    }
};
