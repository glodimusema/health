<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoAffectationAgentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_affectation_agent', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refAgent')->constrained('tmedecin')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refServicePerso')->constrained('tperso_service_personnel')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refCategorieAgent')->constrained('tperso_categorie_service')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateAffectation');
            $table->string('numCimak',50);
            $table->string('numCNSS',50);
            $table->string('numImpot',50);
            $table->string('numcpteBanque',50);
            $table->string('BanqueAgant',50);
            $table->string('autresDetail',50);
            $table->string('author',50);
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
        Schema::dropIfExists('tperso_affectation_agent');
    }
}
