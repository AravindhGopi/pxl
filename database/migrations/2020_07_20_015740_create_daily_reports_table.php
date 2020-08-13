<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('date');
            $table->bigInteger('user_id');
            $table->bigInteger('project_id');
            $table->boolean('is_leave');
            $table->string('leave_type')->nullable();
            $table->string('leave_on')->nullable();
            $table->integer('hours_worked');
            $table->integer('project_specific_training');
            $table->integer('vendor_general_trainings');
            $table->integer('over_time');
            $table->integer('idle_hours');
            $table->string('comments');
            $table->integer('total_hours');
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
        Schema::dropIfExists('daily_reports');
    }
}
