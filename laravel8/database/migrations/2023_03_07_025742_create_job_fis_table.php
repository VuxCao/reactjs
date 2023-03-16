<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobFisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_fis', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('open_positions');
            $table->string('location');
            $table->string('website');
            $table->string('founded');
            $table->string('employees');
            $table->string('industries');
            $table->string('business_model');
            $table->string('funding_state');
            $table->longText('details');
            $table->text('benefits');
            $table->text('team');
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
        Schema::dropIfExists('job_fis');
    }
}
