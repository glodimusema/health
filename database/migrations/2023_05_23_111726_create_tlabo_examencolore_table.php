<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTlaboExamencoloreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::create('tlabo_examencolore', function (Blueprint $table) {
            $table->id();                  
            $table->string('nom_examencolore',50); 
            $table->string('author',50);
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tlabo_examencolore')->insert([
            ['nom_examencolore' => 'EXAMEN1','author' => 'Admin'],
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tlabo_examencolore');
    }
}
