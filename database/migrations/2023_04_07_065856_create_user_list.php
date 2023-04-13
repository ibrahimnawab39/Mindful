<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_list', function (Blueprint $table) {
            $table->id();
            $table->string("username");
            $table->string("religion")->nullable();
            $table->bigInteger('status')->default(0)->comment('0 Requesting, 1 Connected,2 None');
            $table->string("connect_with")->nullable();
            $table->string("interest")->nullable();
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
        Schema::dropIfExists('user_list');
    }
}
