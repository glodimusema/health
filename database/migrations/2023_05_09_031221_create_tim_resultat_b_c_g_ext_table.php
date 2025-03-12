<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimResultatBCGExtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tim_resultat_b_c_g_ext', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refImagerie')->constrained('tim_imagerie_ext')->restrictOnUpdate()->restrictOnDelete();
            $table->String('rythme');
            $table->string('ondee')->nullable();
            $table->string('segmentSt')->nullable();
            $table->string('axe')->nullable();
            $table->string('ondeT')->nullable();
            $table->string('pR')->nullable();
            $table->string('oRS')->nullable();
            $table->string('indices')->nullable();
            $table->string('conclusion')->nullable();
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
        Schema::dropIfExists('tim_resultat_b_c_g_ext');
    }
}
