<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTconfOrganisationaboneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tconf_organisationabone', function (Blueprint $table) {
            $table->id();
            $table->string('nom_org');
            $table->string('adresse_org');
            $table->string('contact_org');
            $table->string('rccm_org');
            $table->string('idnat_org');
            $table->double('pourcentageConvention');
            $table->double('nmbreJourCons')->default(30);
            $table->foreignId('refCategorieSociete')->constrained('tfin_categorie_societe')->restrictOnUpdate()->restrictOnDelete();
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tconf_organisationabone')->insert([
            ['nom_org' => 'Privé(e)','adresse_org' => 'LE VOLCAN','contact_org' => '+243990000000','rccm_org' => '00000','idnat_org' => '00000','pourcentageConvention' => 80,'nmbreJourCons' => 30,'refCategorieSociete' => 1,'author' => 'Admin'],
            ['nom_org' => 'CIGNA','adresse_org' => 'LE VOLCAN','contact_org' => '+243990000000','rccm_org' => '00000','idnat_org' => '00000','pourcentageConvention' => 80,'nmbreJourCons' => 30,'refCategorieSociete' => 2,'author' => 'Admin'],
            ['nom_org' => 'TEARFOUND','adresse_org' => 'LE VOLCAN','contact_org' => '+243990000000','rccm_org' => '00000','idnat_org' => '00000','pourcentageConvention' => 80,'nmbreJourCons' => 30,'refCategorieSociete' => 2,'author' => 'Admin'],
            ['nom_org' => 'JOHANNITER','adresse_org' => 'LE VOLCAN','contact_org' => '+243990000000','rccm_org' => '00000','idnat_org' => '00000','pourcentageConvention' => 80,'nmbreJourCons' => 30,'refCategorieSociete' => 2,'author' => 'Admin'],
            ['nom_org' => 'P.FOODS','adresse_org' => 'LE VOLCAN','contact_org' => '+243990000000','rccm_org' => '00000','idnat_org' => '00000','pourcentageConvention' => 80,'nmbreJourCons' => 30,'refCategorieSociete' => 2,'author' => 'Admin'],
            ['nom_org' => 'KIN FOLOKO','adresse_org' => 'LE VOLCAN','contact_org' => '+243990000000','rccm_org' => '00000','idnat_org' => '00000','pourcentageConvention' => 80,'nmbreJourCons' => 30,'refCategorieSociete' => 2,'author' => 'Admin'],
            ['nom_org' => 'SOLIDAIRE','adresse_org' => 'LE VOLCAN','contact_org' => '+243990000000','rccm_org' => '00000','idnat_org' => '00000','pourcentageConvention' => 80,'nmbreJourCons' => 30,'refCategorieSociete' => 2,'author' => 'Admin'],
            ['nom_org' => 'IRC','adresse_org' => 'LE VOLCAN','contact_org' => '+243990000000','rccm_org' => '00000','idnat_org' => '00000','pourcentageConvention' => 80,'nmbreJourCons' => 30,'refCategorieSociete' => 2,'author' => 'Admin'],
            ['nom_org' => 'PUI','adresse_org' => 'LE VOLCAN','contact_org' => '+243990000000','rccm_org' => '00000','idnat_org' => '00000','pourcentageConvention' => 80,'nmbreJourCons' => 30,'refCategorieSociete' => 2,'author' => 'Admin'],
            ['nom_org' => 'MUSA','adresse_org' => 'LE VOLCAN','contact_org' => '+243990000000','rccm_org' => '00000','idnat_org' => '00000','pourcentageConvention' => 80,'nmbreJourCons' => 30,'refCategorieSociete' => 2,'author' => 'Admin'],
            ['nom_org' => 'MAFAMILLE','adresse_org' => 'LE VOLCAN','contact_org' => '+243990000000','rccm_org' => '00000','idnat_org' => '00000','pourcentageConvention' => 80,'nmbreJourCons' => 30,'refCategorieSociete' => 2,'author' => 'Admin'],
        ]);
    }
    // /refCategorieSociete
//nom_org, adresse_org, contact_org, rccm_org, idnat_org, author
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tconf_organisationabone');
    }
}
