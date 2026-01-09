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
        #	PersonId	FName	SName	TName	LName	MotherName	PrevName	BirthDate	GenderId	FatherId	MotherId	phone	Full Name	Family Members	Phone Number
        # Create the 'heads__households' table
        Schema::create('heads_children', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('PersonId')->unique();
            $table->string('FName');
            $table->string('SName')->nullable();
            $table->string('TName')->nullable();
            $table->string('LName')->nullable();
            $table->date('BirthDate')->nullable();
            $table->string('Gender')->nullable();
            $table->string('Kinship')->nullable();  //  زوج  ، إبن ، إبنة ,زوجة 
            $table->string('health_Status')->nullable(); // سليم ، معاق(حركي وسمعي و بصري و ذهني) ، مزمن , شهيد,مصاب
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
        Schema::dropIfExists('heads_children');
    }
};
