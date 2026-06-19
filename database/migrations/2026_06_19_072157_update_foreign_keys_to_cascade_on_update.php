<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // heads_children
        Schema::table('heads_children', function (Blueprint $table) {

            $table->dropForeign(['householdId']);

            $table->foreign('householdId')
                ->references('PersonId')
                ->on('heads_households')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        // partners
        Schema::table('partners', function (Blueprint $table) {

            $table->dropForeign(['householdId']);

            $table->foreign('householdId')
                ->references('PersonId')
                ->on('heads_households')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        // heads_children
        Schema::table('heads_children', function (Blueprint $table) {

            $table->dropForeign(['householdId']);

            $table->foreign('householdId')
                ->references('PersonId')
                ->on('heads_households')
                ->onDelete('set null');
        });

        // partners
        Schema::table('partners', function (Blueprint $table) {

            $table->dropForeign(['householdId']);

            $table->foreign('householdId')
                ->references('PersonId')
                ->on('heads_households')
                ->onDelete('set null');
        });
    }
};
