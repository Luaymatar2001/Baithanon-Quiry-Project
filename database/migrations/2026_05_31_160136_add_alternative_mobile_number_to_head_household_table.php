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
            $table->string('alternative_mobile_number')->nullable()->after('phone_number');
            //مكان الأقامة داخل غزة او خارج غزة
            $table->string('residence_location')->nullable()->after('alternative_mobile_number');
            $table->string('residence_status')->nullable()->after('residence_location');
            $table->string('international_number_mobile')->nullable()->after('residence_location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('heads_households', function (Blueprint $table) {
            $table->dropColumn('alternative_mobile_number');
            $table->dropColumn('residence_location');
            $table->dropColumn('residence_status');
            $table->dropColumn('international_number_mobile');
        });
    }
};
