<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->bigIncrements('log_id');
            $table->tinyInteger('log_type');
            $table->tinyInteger('log_table_type');
            $table->string('log_ip_address', 100);
            $table->text('log_user_agent');
            $table->unsignedBigInteger('user_id')->commnet('ユーザーID');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->string('log_path', 1000);
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
        Schema::dropIfExists('logs');
    }
}
