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
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('families_count')->default(0);
            $table->unsignedBigInteger('people_count')->default(0);
            $table->unsignedBigInteger('children_count')->default(0);

            $table->timestamp('updated_at')->nullable();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('statistics');
    }
};
