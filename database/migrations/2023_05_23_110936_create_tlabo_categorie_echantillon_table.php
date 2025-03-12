<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTlaboCategorieEchantillonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //tlabo_categorie_echantillon: id,nom_categorieechantillon,author
        Schema::create('tlabo_categorie_echantillon', function (Blueprint $table) {
            $table->id();
            $table->string('nom_categorieechantillon',50);
            $table->string('author',50);  
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user');  
            $table->timestamps();
        });

        DB::table('tlabo_categorie_echantillon')->insert([
            ['nom_categorieechantillon' => 'PARAMETRES', 'author' => 'Admin'],
            ['nom_categorieechantillon' => 'Mobilité', 'author' => 'admin'],
            ['nom_categorieechantillon' => 'Morphologie', 'author' => 'Admin']
        ]);

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tlabo_categorie_echantillon');
    }
}
