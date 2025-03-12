<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatetexamenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('texamen', function (Blueprint $table) {
            $table->id();
            $table->string('designation', 250); 
            $table->double('PrixExam')->default(0);  
            $table->foreignId('refCatexamen')->constrained('tcategorieexament')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refTube')->constrained('ttubeexamen')->restrictOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });


        DB::table('texamen')->insert([
            ['designation' =>'Globule Rouge','refCatexamen' => 1,'refTube' => 1],
            ['designation' =>'Hématocrite (HTC)','refCatexamen' => 1,'refTube' => 1],
            ['designation' =>'Hemoglobine(HB)','refCatexamen' => 1,'refTube' => 1],
            ['designation' =>'Hemogramme complet','refCatexamen' => 1,'refTube' => 1],
            ['designation' =>'Globule Blanc','refCatexamen' => 1,'refTube' => 1],
            ['designation' =>'Formule leucocytaire','refCatexamen' => 1,'refTube' => 1],
            ['designation' =>'Plaquettes','refCatexamen' => 1,'refTube' => 1],
            ['designation' =>'Réticulocytes','refCatexamen' => 1,'refTube' => 1],
            ['designation' =>'VS','refCatexamen' => 1,'refTube' => 1],
            ['designation' =>'Temps de saignement','refCatexamen' => 2,'refTube' => 1],
            ['designation' =>'Temps de coagulation','refCatexamen' => 2,'refTube' => 1],
            ['designation' =>'INR','refCatexamen' => 2,'refTube' => 1],
            ['designation' =>'Tps de Cépha. activée(APTT)','refCatexamen' => 2,'refTube' => 1],
            ['designation' =>'Temps de trombine(TT)','refCatexamen' => 2,'refTube' => 1],
            ['designation' =>'Héparine','refCatexamen' => 2,'refTube' => 1],
            ['designation' =>'Protéine C & protéine S','refCatexamen' => 2,'refTube' => 1],
            ['designation' =>'APC Resistance','refCatexamen' => 2,'refTube' => 1],
            ['designation' =>'D. Dimer','refCatexamen' => 2,'refTube' => 1],
            ['designation' =>'Fibrinogene','refCatexamen' => 2,'refTube' => 1],
            ['designation' =>'Groupe Sanguin et Rhésus','refCatexamen' => 3,'refTube' => 1],
            ['designation' =>'Coombs direct','refCatexamen' => 3,'refTube' => 1],
            ['designation' =>'Coombs indirecte','refCatexamen' => 3,'refTube' => 1],
            ['designation' =>'Electrophorèse d\'Hb','refCatexamen' => 3,'refTube' => 1],
            ['designation' =>'Goutte épaisse','refCatexamen' => 4,'refTube' => 1],
            ['designation' =>'TDR/paludisme','refCatexamen' => 4,'refTube' => 1],
        ]);






    }



    //PrixExam

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('texamen');
    }
}
