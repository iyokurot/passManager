<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UCodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('u_codes', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('service_name');
            $table->string('id_name');
            $table->string('password');
            $table->string('mail');
            $table->string('detail');
            $table->timestamps();
            $table->unique('service_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('u_codes');
    }
}
