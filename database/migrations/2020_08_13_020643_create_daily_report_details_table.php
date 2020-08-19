<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyReportDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_report_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            // hours_worked,project_specific_training,vendor_general_trainings,over_time,idle_hours,comments,total_hours
            $table->bigInteger('daily_report_id');
            $table->integer('project_id');
            $table->integer('hours_worked')->nullable();
            $table->integer('project_specific_training')->nullable();
            $table->integer('partnership_specific_training')->nullable();
            $table->integer('vendor_general_trainings')->nullable();
            $table->integer('over_time')->nullable();
            $table->integer('idle_hours')->nullable();
            $table->string('comments')->nullable();
            $table->integer('total_hours')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_report_details');
    }
}
