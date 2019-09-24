<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatedProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ('projects', function (Blueprint $table)
		{
			$table->bigIncrements ('id');
			$table->string ('name');
			$table->text ('desc');
			$table->bigInteger ('owner');
			$table->enum('view', ['private', 'public']);
			$table->dateTime('due');
			$table->timestamps();
			
			$table->foreign('owner')->references('id')->on('users');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
