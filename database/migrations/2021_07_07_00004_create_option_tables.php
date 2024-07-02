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
        if (!Schema::hasTable('options')) {
            # code...
            Schema::create('options', function (Blueprint $table) {
                $table->increments('id');
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('model_options')) {
            # code...
            Schema::create('model_options', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('key');
                $table->text('value');
                $table->string('model_type');
                $table->unsignedBigInteger('model_id');
                $table->timestamps();
                $table->index(['model_type', 'model_id'], 'model_has_options_model_id_model_type_index');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('options');
    }
}
