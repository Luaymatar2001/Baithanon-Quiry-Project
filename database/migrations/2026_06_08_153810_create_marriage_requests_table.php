<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('marriage_requests', function (Blueprint $table) {
            $table->id();

            // household_id (from current verified household)
            $table->unsignedBigInteger('household_id');

            // Husband data
            $table->string('FName_h');
            $table->string('SName_h')->nullable();
            $table->string('TName_h')->nullable();
            $table->string('LName_h')->nullable();
            $table->string('IdNumHouseHold_h');
            $table->date('BirthDate_h');
            $table->string('MobailNumber_h');

            // Wife data
            $table->string('FName_w');
            $table->string('SName_w')->nullable();
            $table->string('TName_w')->nullable();
            $table->string('LName_w')->nullable();
            $table->string('IdNumWifeId');
            $table->date('BirthDate_w');

            // Images
            $table->string('husband_national_id_image')->nullable();
            $table->string('wife_national_id_image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marriage_requests');
    }
};

