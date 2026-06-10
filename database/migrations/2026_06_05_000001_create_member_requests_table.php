<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('member_requests', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('household_id');

            $table->string('FName', 20);
            $table->string('SName', 20)->nullable();
            $table->string('TName', 20)->nullable();
            $table->string('LName', 20)->nullable();

            $table->string('PersonId', 9);
            $table->string('relation');

            $table->date('BirthDate');

            $table->integer('health_status');
            $table->string('desc_health_status_member', 255)->nullable();

            $table->string('identity_image')->nullable();
            $table->string('birth_certificate')->nullable();
            $table->string('household_id_image')->nullable();

            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');

            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->string('reject_reason')->nullable();

            $table->timestamps();

            // Keep it isolated: no FK constraints added.
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_requests');
    }
};
