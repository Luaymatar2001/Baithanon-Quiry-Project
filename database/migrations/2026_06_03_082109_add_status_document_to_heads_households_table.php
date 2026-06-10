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
            $table->string('status_document')->nullable();
            $table->string('widow_identity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('heads_households', function (Blueprint $table) {
            $table->dropColumn('status_document');
            $table->dropColumn('widow_identity');
        });
    }
};
