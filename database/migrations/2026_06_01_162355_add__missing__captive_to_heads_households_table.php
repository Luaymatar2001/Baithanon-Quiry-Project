<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{


    public function up(): void
    {
        Schema::table('heads_households', function (Blueprint $table) {
            $table->integer('missing_persons')->default(0);
            $table->string('missing_info')->nullable()->after('missing_persons');
            $table->string('level_of_education')->nullable()->after('Notes');
            $table->string('Type_of_housing')->nullable()->after('num_Family_Members');
        });
    }

    public function down(): void
    {
        Schema::table('heads_households', function (Blueprint $table) {
            $table->dropColumn('missing_persons');
            $table->dropColumn('missing_info');
            $table->dropColumn('level_of_education');
            $table->dropColumn('Type_of_housing');
        });
    }
};
