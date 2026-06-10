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
        Schema::create('heads_households', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('PersonId')->unique();
            $table->string('FName');
            $table->string('SName')->nullable();
            $table->string('TName')->nullable();
            $table->string('LName')->nullable();
            $table->date('BirthDate')->nullable();
            $table->string('Gender')->nullable();
            $table->string('Phone_Number')->nullable();
            $table->integer('num_Family_Members')->nullable();
            $table->date('Date_partner_martyrdom')->nullable();
            $table->string('status')->nullable(); //married, single, widowed , multi married , divorced , girl divorced , single a pov 40 years , widowed 2023 ,widowed 7-2023
            $table->string('health_Status')->nullable(); // سليم ، معاق(حركي وسمعي و بصري و ذهني) ، مزمن , شهيد,مصاب
            $table->string('Sources_income')->nullable();// عمل  ,ربة بيت ، لاشيء ، متقاعد ، عاطل عن العمل وموظف حكومي و موظف وكالة و موظف عقود وقطاع خاص
            $table->text('address')->nullable();  
            $table->text('Notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heads_households');
    }
};
