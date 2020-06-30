<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScholarshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unique_registration_number');
            $table->float('amount')->nullable();
            $table->string('type')->nullable();
            $table->string('bank_account')->nullable();
            $table->date('period_start_date')->nullable();
            $table->date('period_end_date')->nullable();

            $table->foreign('unique_registration_number')->references('unique_registration_number')->on('students')->onDelete('cascade');
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
        Schema::dropIfExists('scholarships');
    }
}
