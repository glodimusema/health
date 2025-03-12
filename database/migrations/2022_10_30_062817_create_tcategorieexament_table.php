<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatetcategorieexamentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcategorieexament', function (Blueprint $table) {
            $table->id();
            $table->string('designation', 250);  
            $table->foreignId('refGrandCategorie')->constrained('tgcategorieexament')->restrictOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });

        DB::table('tcategorieexament')->insert([
            ['designation' =>'HEMOGRAMME COMPLET','refGrandCategorie' => 1],
            ['designation' =>'HEMOSTASE','refGrandCategorie' => 1],
            ['designation' =>'IMMUNOHEMATOLOGIE','refGrandCategorie' => 1],
            ['designation' =>'SANG','refGrandCategorie' => 2],
            ['designation' =>'SELLES','refGrandCategorie' => 2],
            ['designation' =>'URINES','refGrandCategorie' => 2],
            ['designation' =>'BIOCHIMIE URINAIRE','refGrandCategorie' => 2],
            ['designation' =>'LCR-LIQUIDE D\'APANCHEMENT','refGrandCategorie' => 2],
            ['designation' =>'SPERMES','refGrandCategorie' => 2],
            ['designation' =>'FROTTIS','refGrandCategorie' => 2],
            ['designation' =>'BILAN RENAL','refGrandCategorie' => 3],
            ['designation' =>'BILAN CARDIAQUE','refGrandCategorie' => 3],
            ['designation' =>'BILAN HEPATIQUE','refGrandCategorie' => 3],
            ['designation' =>'BILAN PANCREATIQUE','refGrandCategorie' => 3],
            ['designation' =>'BILAN LIPIDIQUE','refGrandCategorie' => 3],
            ['designation' =>'ANEMIE','refGrandCategorie' => 3],
            ['designation' =>'BILAN DIABETIQUE','refGrandCategorie' => 3],
            ['designation' =>'IONOGRAMME','refGrandCategorie' => 3],
            ['designation' =>'GAZOMETRIE','refGrandCategorie' => 3],
            ['designation' =>'IMMUNI-SEROLOGIE','refGrandCategorie' => 4],
            ['designation' =>'MARQUEURS TUMORAUX','refGrandCategorie' => 4],
            ['designation' =>'BILAN TORCH','refGrandCategorie' => 4],
            ['designation' =>'MALADIES INFECTIEUSES','refGrandCategorie' => 4],
            ['designation' =>'HORMONOLOGIE','refGrandCategorie' => 5],
            ['designation' =>'BACTERIOLOGIE','refGrandCategorie' => 6],
        ]);







    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tcategorieexament');
    }
}
