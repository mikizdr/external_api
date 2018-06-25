<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('creator_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('user_id');
            $table->integer('club_id');
            $table->integer('role_id');
            $table->string('status');
            $table->string('approval_date')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
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
        Schema::dropIfExists('club_user');
    }
}