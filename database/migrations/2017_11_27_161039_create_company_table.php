<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('logo');
            $table->string('category');
            $table->text('about');
            $table->string('commercial_registration_no');
            $table->date('commercial_registration_expire_date');
            $table->string('commercial_registration_img');
            $table->integer('points');
            $table->integer('company_type');
            $table->string('qr_code');
            $table->integer('rate');
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
        Schema::dropIfExists('company');
    }
}
