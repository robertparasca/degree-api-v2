<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('birth_name')->nullable();
            $table->string('father_name_initial')->nullable();
            $table->unsignedBigInteger('unique_registration_number')->unique();
            $table->string('group')->nullable();
            $table->string('active_year')->nullable();
            $table->string('field_of_study')->nullable();
            $table->string('program_of_study')->nullable();
            $table->float('admission_grade')->nullable();
            $table->string('admission_year')->nullable();
            $table->string('start_year')->nullable();
            $table->boolean('is_paying_tax')->default(false);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('cycle_of_study')->default(1); // 1 - licenta, 2 - master, 3 - doctorat
            $table->unsignedBigInteger('language')->default(0); // 0 - romana, 1 - engleza
            $table->boolean('is_ID')->default(false); // 0 - romana, 1 - engleza

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
