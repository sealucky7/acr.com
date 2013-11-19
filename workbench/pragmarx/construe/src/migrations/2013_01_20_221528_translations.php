<?php

use Illuminate\Database\Migrations\Migration;

class Translations extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('construe_translations', function($table)
        {
            $table->increments('id',3);

            $table->integer('message_id');
            $table->string('language_id',3);                    // pt
            $table->string('country_id',3);                     // br
            $table->text('message');                            // this is the full text translation
            $table->integer('translator_id')->nullable();       // possible user_id

            $table->timestamps();                       

            $table->unique(array('language_id','country_id','message_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('construe_translations');
    }

}
