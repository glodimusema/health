<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopeAnesthesieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tope_anesthesie', function (Blueprint $table) {
             $table->id();
             $table->foreignId('refEnteteOperation')->constrained('tope_enteteoperation')->restrictOnUpdate()->restrictOnDelete();
             $table->date('dateAnesthesie',5);
             $table->string('diagnosticpreop',5);
             $table->string('interventionEnvisagee',5);
             $table->date('datePrevue',5);
             $table->string('programme',5);
             $table->string('urgence',5);
             $table->string('reprise',5);
             $table->string('chirurgieAnterieur',5);
             $table->string('anesthesieAnterieur',5);
             $table->string('protocole',5);
             $table->string('complication',5);
             $table->string('pathologieAnterieur',5);
             $table->string('nerveux',5);
             $table->string('renal',5);
             $table->string('cardio_circ',5);
             $table->string('pulmonaire',5);
             $table->string('foie',5);
             $table->string('autresysteme',5);
             $table->string('ddr',5);
             $table->string('G_autres',5);
             $table->string('P_autres',5);
             $table->string('A_autres',5);
             $table->string('D_autres',5);
             $table->string('cardiophatie',5);
             $table->string('diabete',5);
             $table->string('asthme',5);
             $table->string('tabac',5);
             $table->string('alcool',5);
             $table->string('hypertension',5);
             $table->string('epilepsie',5);
             $table->string('alllergie',5);
             $table->string('transfusion',5);
             $table->string('medicament_drogue',5);
             $table->string('etatgeneral',5);
             $table->string('conscience',5);
             $table->string('forcemusculaire',5);
             $table->string('bouche',5);
             $table->string('mallampatie',5);
             $table->string('conjonctive',5);
             $table->string('rhume',5);
             $table->string('taux',5);
             $table->string('respiration',5);
             $table->string('choc_de_pointe',5);
             $table->string('expectoration',5);
             $table->string('auscultation',5);
             $table->string('poumon',5);
             $table->string('coeurs',5);
             $table->string('abdomen',5);
             $table->string('dos',5);
             $table->string('membres',5);
             $table->string('TA',5);
             $table->string('FC',5);
             $table->string('FR',5);
             $table->string('AutresSigneVitaux',5);
             $table->string('HB',5);
             $table->string('GS',5);
             $table->string('RH',5);
             $table->string('HT',5);
             $table->string('TS',5);
             $table->string('TC',5);
             $table->string('Plaquette',5);
             $table->string('HIV',5);
             $table->string('FLN',5);
             $table->string('FLL',5);
             $table->string('FLM',5);
             $table->string('FLE',5);
             $table->string('FLB',5);
             $table->string('GB',5);
             $table->string('GR',5);
             $table->string('Uree',5);
             $table->string('Creat',5);
             $table->string('SGOT',5);
             $table->string('SGPT',5);
             $table->string('Lono',5);
             $table->string('Glycemie',5);
             $table->string('T3',5);
             $table->string('T4',5);
             $table->string('Albimines',5);
             $table->string('Emmel',5);
             $table->string('SAO2',5);
             $table->string('RX',5);
             $table->string('ECG',5);
             $table->string('EhoCardiaque',5);
             $table->string('Patient',5);
             $table->string('Anesthesie',5);
             $table->string('Chirurgie',5);
             $table->string('Jeune',5);
             $table->string('Rasage',5);
             $table->string('Lavement',5);
             $table->string('AutresCommandations',5);
             $table->string('LibelleAutresCommandation',5);
             $table->string('Anesthesiste',5);
             $table->string('Chirurgien',5);
             $table->string('sousigne',5);
             $table->date('dateSousigne',5);
             $table->string('temoins',5);
             $table->string('nomPatient',5);            
             $table->string('serviceAnestesie',5);
             $table->string('numeroServ',5);
             $table->string('author',5);
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
        Schema::dropIfExists('tope_anesthesie',5);
    }
}
