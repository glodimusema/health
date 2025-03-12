<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTgcategorieexamentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tgcategorieexament', function (Blueprint $table) {
            $table->id();
            $table->string('designation', 250);
            $table->timestamps();
        });

        DB::table('tgcategorieexament')->insert([
            ['designation' => 'HEMATOLOGIE'],
            ['designation' => 'PARASITOLOGIE'],
            ['designation' => 'BIOCHIMIE'],
            ['designation' => 'IMMUNO-SEROLOGIE'],
            ['designation' => 'HORMONOLOGIE'],
            ['designation' => 'BACTERIOLOGIE'],
            ['designation' => 'BILOGIE MOLECULAIRE'],
            ['designation' => 'IONOGRAMME']
        ]);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tgcategorieexament');
    }
}
