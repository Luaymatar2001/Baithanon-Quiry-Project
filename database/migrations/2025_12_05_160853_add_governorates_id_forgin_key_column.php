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
        Schema::table('city', function (Blueprint $table) {
            // $table->unsignedBigInteger('governorateId')->nullable();
            // $table->foreign('governorateId')->references('id')->on('governorates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('city', function (Blueprint $table) {
            $table->dropForeign(['governorateId']);
            $table->dropColumn('governorateId');
        });
    }
};
