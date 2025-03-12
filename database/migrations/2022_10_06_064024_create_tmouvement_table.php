<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatetmouvementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('tmouvement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refMalade')->constrained('tclient')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refTypeMouvement')->constrained('ttypemouvement_malade')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('idOrganisation')->constrained('tconf_organisationabone')->restrictOnUpdate()->restrictOnDelete();                
            $table->double('agemvt');
            $table->double('age_jourmvt');
            $table->double('age_moismvt'); 
            $table->date('dateMouvement')->nullable()->default(null); 
            $table->string('organisationAbonne');    
            $table->double('taux_prisecharge');
            $table->double('pourcentageConvention')->default(0);
            $table->double('nmbreJourConsMvt')->default(15);  
            $table->string('categoriemaladiemvt')->default('Privé(e)');
            $table->string('numCartemvt')->default('00000'); 
            $table->string('numroBon')->default('00000');
            $table->string('Statut')->default('Encours'); 
            $table->date('dateSortieMvt')->nullable()->default(null);
            $table->string('motifSortieMvt')->default('');
            $table->string('autoriseSortieMvt')->default('');      
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();

            //age_jourmvt,age_moismvt
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tmouvement');
    }
}
