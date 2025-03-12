<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimAttestationExtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tim_attestation_ext', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refDetailConst')->constrained('tdetailconsultation')->restrictOnUpdate()->restrictOnDelete();
            $table->string('medecin1',100);
            $table->string('specialite1',100);
            $table->string('cnom1',100);
            $table->string('medecin2',100);
            $table->string('specialite2',100);
            $table->string('cnom2',100);
            $table->string('medecin3',100);
            $table->string('specialite3',100);
            $table->string('cnom3',100);
            $table->string('medecin4',100);
            $table->string('specialite4',100);
            $table->string('cnom4',100);
            $table->date('datelivraison',100);
            $table->string('author',100);
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });
    }

    //id,refDetailConst,descriptionAttest,conclusionAttest,medecin1,specialite1,cnom1,medecin2,specialite2,cnom2,
    //medecin3,specialite3,cnom3,medecin4,specialite4,cnom4,datelivraison,author
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tim_attestation_ext');
    }
}
