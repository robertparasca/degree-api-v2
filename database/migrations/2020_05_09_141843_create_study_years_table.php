<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudyYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_years', function (Blueprint $table) {
            $table->id();
            $table->date('year_start_date');
            $table->date('year_end_date');
            $table->date('semester1_start_date');
            $table->date('semester1_end_date');
            $table->date('semester2_start_date');
            $table->date('semester2_end_date');
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
        Schema::dropIfExists('study_years');
    }
}
