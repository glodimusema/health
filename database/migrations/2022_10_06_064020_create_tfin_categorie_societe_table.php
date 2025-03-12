<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTfinCategorieSocieteTable extends Migration
{
    //
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tfin_categorie_societe', function (Blueprint $table) {
            $table->id();
            $table->string('name_categorie_societe');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tfin_categorie_societe')->insert([
            ['name_categorie_societe' => 'CATEGORIE PRIVEE'],
            ['name_categorie_societe' => 'CATEGORIE ABONEE STANDARD'],
            ['name_categorie_societe' => 'CATEGORIE CONVENTION (CIGNA)'],
            ['name_categorie_societe' => 'CATEGORIE CONVENTION (GLOBAL ACCESS)'],
            ['name_categorie_societe' => 'CATEGORIE CONVENTION (WORLD VISION)'],
            ['name_categorie_societe' => 'CATEGORIE ABONNE 4'],
            ['name_categorie_societe' => 'CATEGORIE ABONNE 5']
        ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tfin_categorie_societe');
    }
}
