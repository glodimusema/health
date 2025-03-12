<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 

class CreateTconfCategoriemaladieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tconf_categoriemaladie', function (Blueprint $table) {
            $table->id();
            $table->string('nom_categoriemaladie', 250);
            $table->timestamps();
        });

        DB::table('tconf_categoriemaladie')->insert([
            ['nom_categoriemaladie' => 'MALADIE CHRONIQUE'],
            ['nom_categoriemaladie' => 'Autres nouveaux cas'],
            ['nom_categoriemaladie' => 'Caracteristique des nouveaux cas'],
            ['nom_categoriemaladie' => 'Consultations curatives'],
            ['nom_categoriemaladie' => 'Diarrhée'],
            ['nom_categoriemaladie' => 'IST'],
            ['nom_categoriemaladie' => 'Notification des nouveaux cas (Partie 1)'],
            ['nom_categoriemaladie' => 'Paludisme'],
            ['nom_categoriemaladie' => 'Paludisme femme enceinte'],
            ['nom_categoriemaladie' => 'Pneumonie'],
            ['nom_categoriemaladie' => 'Suvivant des violences sexuelles'],
            ['nom_categoriemaladie' => 'BACTERIENNE'],
            ['nom_categoriemaladie' => 'PLAIE TRAUMATIQUE'],
            ['nom_categoriemaladie' => 'CAS D\'ESTHETIQUE DENTO- FACIAL']
        ]);







    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tconf_categoriemaladie');
    }
}
