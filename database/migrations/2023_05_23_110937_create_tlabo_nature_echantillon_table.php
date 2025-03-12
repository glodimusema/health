<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTlaboNatureEchantillonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //id,designation_nature,designation_valeur,refCategorieEchantillon,author

        Schema::create('tlabo_nature_echantillon', function (Blueprint $table) {
            $table->id();
            $table->string('designation_nature',50); 
            $table->string('designation_valeur',50);
            $table->foreignId('refCategorieEchantillon')->constrained('tlabo_categorie_echantillon')->restrictOnUpdate()->restrictOnDelete();
            $table->string('author',50);  
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user');          
            $table->timestamps();
        });

        DB::table('tlabo_nature_echantillon')->insert([
            ['designation_nature' => 'Heure de prélèvement','designation_valeur' => '<20 minutes','refCategorieEchantillon' => 1, 'author' => 'Admin']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tlabo_nature_echantillon');
    }
}
