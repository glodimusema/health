<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdyalDoseCathetereTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdyal__dose_cathetere', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteDyalise')->constrained('tdyal_entete_dyalise')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refTypeMachine')->constrained('tdyal_type_machine')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateDose');
            $table->string('KT');
            $table->string('CM_marque');
            $table->string('Dimension');
            $table->string('lieu');
            $table->string('autres');
            $table->string('operateur_Dr');
            $table->string('assistant');
            $table->string('infirmier');
            $table->string('descriptionOperation');
            $table->string('PA_avant');
            $table->string('PA_apres');
            $table->string('pauls_avant');
            $table->string('pauls_apres');
            $table->string('saO2_avant');
            $table->string('saO2_apres');
            $table->string('to_avant');
            $table->string('to_apres');
            $table->string('observation');
            $table->string('instruction');
            $table->string('indication');  
            $table->string('shifts');
            $table->string('siteactuel');   
            $table->string('FR_avant');
            $table->string('FR_Apres');  
            $table->string('Plaquette_avant'); 
            $table->string('Plaquette_apres');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();

    //         'id','refEnteteDyalise','refTypeMachine','indication',
    // 'dateDose','shifts','KT','CM_marque','Dimension','siteactuel','lieu','autres','operateur_Dr',
    // 'assistant','infirmier','descriptionOperation','PA_avant','PA_apres','pauls_avant','pauls_apres',
    // "FR_avant","FR_Apres",'saO2_avant','saO2_apres','to_avant','to_apres',"Plaquette_avant", 
    // "Plaquette_apres",'observation','instruction'
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tdyal__dose_cathetere');
    }
}
