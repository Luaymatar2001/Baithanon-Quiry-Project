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
        Schema::table('heads_children', function (Blueprint $table) {
            $table->string('desc_health_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('heads_children', function (Blueprint $table) {
            $table->dropColumn('desc_health_status');
            //
        });
    }
};
