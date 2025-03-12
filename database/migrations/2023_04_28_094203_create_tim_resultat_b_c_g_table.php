<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimResultatBCGTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tim_resultat_b_c_g', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refImagerie')->constrained('tim_imagerie')->restrictOnUpdate()->restrictOnDelete();
            $table->String('rythme');
            $table->string('ondee')->nullable();
            $table->string('segmentSt')->nullable();
            $table->string('axe')->nullable();
            $table->string('ondeT')->nullable();
            $table->string('pR')->nullable();
            $table->string('oRS')->nullable();
            $table->string('indices')->nullable();
            $table->string('conclusion')->nullable();
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
            $table->string('author')->nullable();
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
        Schema::dropIfExists('tim_resultat_b_c_g');
    }
}
