<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->string('command');
            $table->string('expression')->nullable(); // * * * * * - default value cron expression
            $table->boolean('is_active')->default(true); // default value of true
            $table->boolean('dont_overlap')->default(false); // default value of false
            $table->boolean('run_in_maintenance')->default(false); // default value of false
            $table->string('notification_email')->nullable(); // can be empty
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
        Schema::dropIfExists('tasks');
    }
}
