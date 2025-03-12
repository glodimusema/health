<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopeAnesthesiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tope_anesthesies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteOpe')->constrained('tope_enteteoperation')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateAnesthesie');
            $table->string('diagnosticpreop',100)->nullable();
            $table->string('interventionEnvisagee',100)->nullable();
            $table->date('datePrevue');
            $table->string('programme',15)->nullable();
            $table->string('urgence',15)->nullable();
            $table->string('reprise',15)->nullable();
            $table->string('chirurgieAnterieur',15)->nullable();
            $table->string('anesthesieAnterieur',15)->nullable();
            $table->string('protocole',15)->nullable();
            $table->string('complication',15)->nullable();
            $table->string('pathologieAnterieur',15)->nullable();
            $table->string('nerveux',15)->nullable();
            $table->string('renal',15)->nullable();
            $table->string('cardio_circ',15)->nullable();
            $table->string('pulmonaire',15)->nullable();
            $table->string('foie',15)->nullable();
            $table->string('denstisterie',50)->nullable();
            $table->string('tromato_orthopedi',50)->nullable();
            $table->string('chirurgie_cardiaque',50)->nullable();
            $table->string('allergie_chirurgie',50)->nullable();
            $table->string('autresysteme',15)->nullable();
            $table->string('ddr',15)->nullable();
            $table->string('G_autres',15)->nullable();
            $table->string('P_autres',15)->nullable();
            $table->string('A_autres',15)->nullable();
            $table->string('D_autres',15)->nullable();
            $table->string('cardiophatie',15)->nullable();
            $table->string('diabete',15)->nullable();
            $table->string('asthme',15)->nullable();
            $table->string('tabac',15)->nullable();
            $table->string('alcool',15)->nullable();
            $table->string('hypertension',15)->nullable();
            $table->string('epilepsie',15)->nullable();
            $table->string('alllergie',15)->nullable();
            $table->string('transfusion',15)->nullable();
            $table->string('medicament_drogue',15)->nullable();
            $table->string('etatgeneral',15)->nullable();
            $table->string('conscience',15)->nullable();
            $table->string('forcemusculaire',15)->nullable();
            $table->string('bouche',15)->nullable();
            $table->string('mallampatie',15)->nullable();
            $table->string('conjonctive',15)->nullable();
            $table->string('rhume',15)->nullable();
            $table->string('taux',15)->nullable();
            $table->string('respiration',15)->nullable();
            $table->string('choc_de_pointe',15)->nullable();
            $table->string('expectoration',15)->nullable();
            $table->string('auscultation',15)->nullable();
            $table->string('poumon',15)->nullable();
            $table->string('coeurs',15)->nullable();
            $table->string('abdomen',15)->nullable();
            $table->string('dos',15)->nullable();
            $table->string('membres',15)->nullable();
            $table->string('TA_Anest',15)->nullable();
            $table->string('FC_Anest',15)->nullable();
            $table->string('FR_Anest',15)->nullable();
            $table->string('AutresSigneVitaux',15)->nullable();
            $table->string('HB',15)->nullable();
            $table->string('GS',15)->nullable();
            $table->string('RH',15)->nullable();
            $table->string('HT',15)->nullable();
            $table->string('TS',15)->nullable();
            $table->string('TC',15)->nullable();
            $table->string('Plaquette',15)->nullable();
            $table->string('HIV',15)->nullable();
            $table->string('FLN',15)->nullable();
            $table->string('FLL',15)->nullable();
            $table->string('FLM',15)->nullable();
            $table->string('FLE',15)->nullable();
            $table->string('FLB',15)->nullable();
            $table->string('GB',15)->nullable();
            $table->string('GR',15)->nullable();
            $table->string('Uree',15)->nullable();
            $table->string('Creat',15)->nullable();
            $table->string('SGOT',15)->nullable();
            $table->string('SGPT',15)->nullable();
            $table->string('Lono',15)->nullable();
            $table->string('Glycemie',15)->nullable();
            $table->string('T3',15)->nullable();
            $table->string('T4',15)->nullable();
            $table->string('Albimines',15)->nullable();
            $table->string('Emmel',15)->nullable();
            $table->string('SAO2',15)->nullable();
            $table->string('RX',15)->nullable();
            $table->string('ECG',15)->nullable();
            $table->string('EhoCardiaque',15)->nullable();
            $table->string('Patient',50)->nullable();
            $table->string('Anesthesie',50)->nullable();
            $table->string('Chirurgie',50)->nullable();
            $table->string('Jeune',15)->nullable();
            $table->string('Rasage',15)->nullable();
            $table->string('Lavement',15)->nullable();
            $table->string('AutresCommandations',50)->nullable();
            $table->string('LibelleAutresCommandation',50)->nullable();
            $table->string('Anesthesiste',50)->nullable();
            $table->string('Chirurgien',50)->nullable();
            $table->string('sousigne',50)->nullable();
            $table->date('dateSousigne');
            $table->string('temoins',50)->nullable();
            $table->string('nomPatient',50)->nullable();    
            $table->string('serviceAnestesie',50)->nullable();    
            $table->string('author',50)->nullable();
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
        Schema::dropIfExists('tope_anesthesies');
    }
}
