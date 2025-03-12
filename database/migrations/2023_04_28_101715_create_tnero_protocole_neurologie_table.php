<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTneroProtocoleNeurologieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tnero_protocole_neurologie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refDetailConst')->constrained('tdetailconsultation')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('reftyperapport')->constrained('tnero_type_rapport')->restrictOnUpdate()->restrictOnDelete();
            $table->string('medecin1',100);
            $table->string('specialite1',100);
            $table->string('cnom1',100);
            $table->string('medecin2',100);
            $table->string('specialite2',100);
            $table->string('cnom2',100);
            $table->string('medecin3',100);
            $table->string('specialite3',100);
            $table->string('cnom3',100);
            $table->string('preambule',100);
            $table->string('developpement',100);
            $table->string('traitementsRecus',100);
            $table->string('conclusion',100);
            $table->string('recomandation',100);
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
        Schema::dropIfExists('tnero_protocole_neurologie');
    }
}
