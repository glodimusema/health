<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtAttestCertificatMedicalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tt_attest_certificat_medical', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refAttestation')->constrained('tt_attest_entete_attestation')->restrictOnUpdate()->restrictOnDelete();
            $table->string('thoracique');
            $table->string('indiceDePignat',100);
            $table->string('indiceVerbaeck',100);
            $table->string('SignesLesion',100);
            $table->string('etetDeSante',100);
            $table->string('remarque',100);
            $table->string('conclusion',100);
            $table->date('dateDebut',100);
            $table->date('dateFin',100);
            $table->string('examination',100);
            $table->string('author',100);
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
        Schema::dropIfExists('tt_attest_certificat_medical');
    }
}
