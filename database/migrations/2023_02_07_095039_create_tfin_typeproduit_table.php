<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
class CreateTfinTypeproduitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tfin_typeproduit', function (Blueprint $table) {
            $table->id();
            $table->string('nom_typeproduit');
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tfin_typeproduit')->insert([
            ['nom_typeproduit' => 'ACTE MEDICAL','author' => 'Admin'],
            ['nom_typeproduit' => 'MEDICAMENT','author' => 'Admin'],
            ['nom_typeproduit' => 'MATERIEL','author' => 'Admin'],
            ['nom_typeproduit' => 'CONSULTATION','author' => 'Admin'],
            ['nom_typeproduit' => 'EXAMEN','author' => 'Admin'],
            ['nom_typeproduit' => 'IMAGERIES','author' => 'Admin'],
            ['nom_typeproduit' => 'HOSPITALISATION','author' => 'Admin']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tfin_typeproduit');
    }
}
