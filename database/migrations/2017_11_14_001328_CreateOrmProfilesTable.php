<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrmProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orm_profiles', function ($table) {
            $table->increments('id');
            $table->boolean('active')->default(false);
            $table->string('email');
            $table->string('secret');
            $table->string('host');
            $table->integer('port')->default(80);
            $table->integer('version')->default(1);
            $table->boolean('use_ssl')->default(false);
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
        Schema::dropIfExists('orm_profiles');
    }
}
