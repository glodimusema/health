<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimAttestationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tim_attestation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refDetailConst')->constrained('tdetailconsultation')->restrictOnUpdate()->restrictOnDelete();
            $table->string('descriptionAttest',100);
            $table->string('conclusionAttest',100);
            $table->string('medecin1')->nullable();
            $table->string('specialite1')->nullable();
            $table->string('cnom1')->nullable();
            $table->string('medecin2')->nullable();
            $table->string('specialite2')->nullable();
            $table->string('cnom2')->nullable();
            $table->string('medecin3')->nullable();
            $table->string('specialite3')->nullable();
            $table->string('cnom3')->nullable();
            $table->string('medecin4')->nullable();
            $table->string('specialite4')->nullable();
            $table->string('cnom4')->nullable();
            // $table->string('adresseResidence',100);
            $table->date('datelivraison',100);
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
        Schema::dropIfExists('tim_attestation');
    }
}
