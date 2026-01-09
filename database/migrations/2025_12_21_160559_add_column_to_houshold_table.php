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
            $table->unsignedBigInteger('location_id')->nullable()->after('cityId');
            $table->unsignedBigInteger('governorate_id')->nullable()->after('location_id');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
            $table->foreign('governorate_id')->references('id')->on('governorates')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('houshold', function (Blueprint $table) {
            //
        });
    }
};
