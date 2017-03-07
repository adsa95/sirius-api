<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHttpExtensions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('http_plugins', function(Blueprint $table){
            $table->increments('id');
            $table->char('sirius_id', 64);
            $table->string('url');
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->json('config')->nullable();
            $table->timestamps();
        });

        Schema::table('configs', function($table){
            $table->json('http_extensions')->default('[]');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('http_plugins');

        Schema::table('configs', function($table){
            $table->dropColumn('http_extensions');
        });
    }
}
