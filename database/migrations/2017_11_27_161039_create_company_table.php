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
            $table->integer('user_id');
            $table->integer('category_id');
            $table->string('company_code');
            $table->text('about');
            $table->string('commercial_registration_no');
            $table->date('commercial_registration_expire_date');
            $table->string('commercial_registration_img');
            $table->integer('points');
            $table->string('qr_code');
            $table->string('word_hours');
            $table->string('instagram');
            $table->string('facebook');
            $table->string('twitter');
            $table->string('twitter');
            $table->string('snapshat');
            $table->string('website');
            $table->boolean('special');
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
