<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedSmallInteger('task_id');
            // $table->foreign('task_id')->references('id')->on('tasks');
            $table->timestamp('ran_at')->useCurrent(); // uses current time stamp
            $table->string('duration');
            $table->longText('result');
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
        Schema::dropIfExists('tasks_results');
    }
}
