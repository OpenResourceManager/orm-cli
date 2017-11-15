<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateORMSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orm_sessions', function ($table) {
            $table->increments('id');
            $table->integer('profile_id')->unsigned();
            $table->string('orm');
            $table->timestamps();
            $table->foreign('profile_id')->references('id')->on('orm_profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orm_sessions', function (Blueprint $table) {
            $table->dropForeign('orm_sessions_profile_id_foreign');
        });
        Schema::dropIfExists('orm_sessions');
    }
}
