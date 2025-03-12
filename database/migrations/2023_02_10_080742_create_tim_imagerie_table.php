<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimImagerieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tim_imagerie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refDetailConst')->constrained('tdetailconsultation')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refAnalyse')->constrained('tim_analyse')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateImagerie',100);
            $table->string('clinique',100);
            $table->string('but',100);
            $table->string('urgent',100);
            $table->string('serviceProvenance',100);
            $table->string('medecindemandeur',100);
            $table->string('medecinProtocolaire')->default('Encours');
            $table->string('specialiste',100)->default('Encours');
            $table->string('CNOM',100)->default('Encours');
            $table->string('examenDemande',100)->default('Encours');
            $table->string('author',100);
            $table->string('status',100)->default('Attente');
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
        Schema::dropIfExists('tim_imagerie');
    }
}
