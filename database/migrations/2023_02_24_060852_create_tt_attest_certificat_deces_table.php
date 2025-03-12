<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtAttestCertificatDecesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tt_attest_certificat_deces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refAttestation')->constrained('tt_attest_entete_attestation')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateAdmise');
            $table->string('heure',100);
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
        Schema::dropIfExists('tt_attest_certificat_deces');
    }
}
