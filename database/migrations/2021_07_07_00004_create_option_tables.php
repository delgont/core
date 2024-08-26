<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->id('id');
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('identifier')->nullable();
            $table->timestamps();
        });



        Schema::create('model_key_value_properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key');
            $table->text('value');
            $table->string('group')->default('general'); //can be -> general, setting, phone, email
            $table->string('cast')->nullable();
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->timestamps();
            $table->unique(['model_id', 'model_type', 'key','group'], 'model_has_unique_grouped_key_value_properties');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('options');
        Schema::dropIfExists('model_options');
        Schema::dropIfExists('modes_of_payment');
    }
}
