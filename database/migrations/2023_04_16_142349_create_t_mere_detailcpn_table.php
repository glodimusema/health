<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTMereDetailcpnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_mere_detailcpn', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refCPN')->constrained('t_mere_consultation_prenatale')->restrictOnUpdate()->restrictOnDelete();
            $table->datetime('date_visite')->nullable();
            $table->string('typeCPN')->nullable();
            $table->string('plaintes_notes')->nullable();
            $table->string('depistage')->nullable();  
            $table->string('peauSeche')->nullable();
            $table->string('etatGenerale')->nullable();
            $table->string('poids_detailCPN')->nullable();
            $table->string('bP')->nullable();
            $table->string('presence_cecite')->nullable();
            $table->string('presence_goittre')->nullable();
            $table->string('plaintes_fievre')->nullable();
            $table->string('temps_valeur')->nullable();
            $table->string('duirese_oui_non')->nullable();
            $table->string('pertes_liquidiennes')->nullable();
            $table->string('ta_detailCPN')->nullable();
            $table->string('proteine_DetCPN')->nullable();
            $table->string('oedemes_detCPN')->nullable();
            $table->string('coloration_conjonctive')->nullable();
            $table->string('paules_valeurs')->nullable();
            $table->string('etatSein_normal')->nullable();
            $table->string('presence_masse')->nullable();
            $table->string('ago_grossesse')->nullable();
            $table->string('mouvement_foetus')->nullable();
            $table->string('hauteur_uterine_detCPN')->nullable();
            $table->string('BCF')->nullable();
            $table->string('presentationFoetus_detCPN')->nullable();
            $table->string('pres_transversale')->nullable();
            $table->string('Bclampsie')->nullable();
            $table->string('signes_symptomes')->nullable();
            $table->string('Etat_col_detCPN')->nullable();
            $table->string('conduite_DetCpn')->nullable();
            $table->string('author');
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
        Schema::dropIfExists('t_mere_detailcpn');
    }
}
