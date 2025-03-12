<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopeActeoperatoireTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tope_acteoperatoire', function (Blueprint $table) {
            $table->id();            
            $table->string('nom_acteop');
            $table->double('prix_acteop');   
            $table->string('aurhor');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user');            
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
        Schema::dropIfExists('tope_acteoperatoire');
    }
}
