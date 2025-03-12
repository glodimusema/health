<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopeTypeanesthesieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tope_typeanesthesie', function (Blueprint $table) {
            $table->id();
            $table->string('nom_tyepeanesthesie');
            $table->double('prix_typeanesthesie');   
            $table->string('aurhor');  
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        
        DB::table('tope_typeanesthesie')->insert([
            ['nom_tyepeanesthesie' => 'Anestesie1','prix_typeanesthesie' => 20,'aurhor' => 'Admin']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tope_typeanesthesie');
    }
}
