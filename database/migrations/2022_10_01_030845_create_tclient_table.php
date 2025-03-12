<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatetClientTable extends Migration
{
    /**
     * Run the migrations.
     *photoslug
     * @return void
     */
    public function up()
    {
        Schema::create('tclient', function (Blueprint $table) {
            $table->id();
            $table->string('noms'); 
            $table->string('contact'); 
            $table->string('mail'); 
            $table->foreignId('refAvenue')->constrained('avenues')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refCategieClient')->constrained('tcategorieclient')->restrictOnUpdate()->restrictOnDelete();
            $table->string('sexe_malade');
            $table->date('dateNaissance_malade');
            $table->string('etatcivil_malade');
            $table->string('numeroMaison_malade');
            $table->string('fonction_malade');
            $table->string('groupesanguin');
            $table->string('personneRef_malade');
            $table->string('fonctioPersRef_malade');
            $table->string('contactPersRef_malade');
            $table->string('organisation_malade');
            $table->string('numeroCarte_malade');
            $table->date('dateExpiration_malade');             
            $table->string('photo'); 
            $table->string('slug'); 
            $table->string('author');   
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
        Schema::dropIfExists('tclient');
    }
}
