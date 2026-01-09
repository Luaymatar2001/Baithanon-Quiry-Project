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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('PersonId');
            $table->string('FName');
            $table->string('SName')->nullable();
            $table->string('TName')->nullable();
            $table->string('LName')->nullable();
            $table->string('relationship');
            $table->date('birthdate')->nullable();
            // health_Status
            $table->string('health_status')->nullable();
            $table->unsignedBigInteger('householdId')->nullable();
            $table->foreign('householdId')->references('PersonId')->on('heads_households')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
