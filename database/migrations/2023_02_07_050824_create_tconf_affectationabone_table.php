<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTconfAffectationaboneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tconf_affectationabone', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refMalade')->constrained('tclient')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refOrganisation')->constrained('tconf_organisationabone')->restrictOnUpdate()->restrictOnDelete();
            $table->double('tauxcharge');
            $table->string('statut')->default('Encours');            
            $table->string('author');  
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });
    }
//refMalade,refOrganisation, tauxcharge, statut, author
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tconf_affectationabone');
    }
}
