<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('number')->unique();
            $table->string('item');
            $table->string('location');
            $table->string('shop');
            $table->date('due_date')->nullable();
            $table->string('img_url1')->nullable();
            $table->string('img_url2')->nullable();
            $table->string('img_url3')->nullable();
            $table->string('img_url4')->nullable();
            $table->string('taken_img1')->nullable();
            $table->string('taken_img2')->nullable();
            $table->string('taken_img3')->nullable();
            $table->string('taken_img4')->nullable();
            $table->tinyInteger('status')->default(0);
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
