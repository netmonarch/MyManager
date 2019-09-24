<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatedTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create ('tasks', function (Blueprint $table)
		{
		
			$table->bigIncrements ('id');
			$table->string ('name');
			$table->text ('desc');
			$table->bigInteger('owner');
			$table->bigInteger('parent');
			$table->tinyInteger('status')->default(0);
			$table->dateTime('due');
			$table->timestamps();
			$table->foreign('owner')->references('id')->on('users');
			$table->foreign('parent')->references('id')->on('projects');
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