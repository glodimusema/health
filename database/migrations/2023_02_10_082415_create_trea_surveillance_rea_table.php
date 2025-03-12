<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreaSurveillanceReaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trea_surveillance_rea', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteRea')->constrained('trea_entete_rea')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateTraiteRea',100);
            $table->string('pauls',100);
            $table->string('heureTraite',100);
            $table->string('PAS',100);
            $table->string('diagosticRea',100);
            $table->string('PAD',100);
            $table->string('temperatureTrait',100);
            $table->string('ta',100);
            $table->string('pam',100);
            $table->string('spo2',100);
            $table->string('scareGlosgow',100);
            $table->string('mode_vendilatoire',100);
            $table->string('volmin',100);
            $table->string('fi02',100);
            $table->string('frequence',100);
            $table->string('peep',100);
            $table->string('Fr_traitRea',100);
            $table->string('tempsInstall',100);
            $table->string('tempsPause',100);
            $table->string('oxygeneTraitRea',100);
            $table->string('contrepressionMax',100);
            $table->string('oxygene',100);
            $table->string('pressionCrate',100);
            $table->string('auther',100);
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
        Schema::dropIfExists('trea_surveillance_rea');
    }
}
