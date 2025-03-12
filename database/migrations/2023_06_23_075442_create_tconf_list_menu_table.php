<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
class CreateTconfListMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tconf_list_menu', function (Blueprint $table) {
            $table->id();
            $table->string('name_menu');
            $table->string('numero_menu');
            $table->timestamps();
        });

        //numero_menu

        DB::table('tconf_list_menu')->insert([
            ['name_menu' => 'Réception', 'numero_menu' =>'1'],
            ['name_menu' => 'Consultation', 'numero_menu' =>'2'],
            ['name_menu' => 'Urgence', 'numero_menu' =>'3'],
            ['name_menu' => 'Pediatrie', 'numero_menu' =>'4'],
            ['name_menu' => 'Laboratoire', 'numero_menu' =>'5'],
            ['name_menu' => 'Imageries', 'numero_menu' =>'6'],
            ['name_menu' => 'Dialyse', 'numero_menu' =>'7'],
            ['name_menu' => 'Kinésithérapie', 'numero_menu' =>'8'],
            ['name_menu' => 'Hospitalisation', 'numero_menu' =>'9'],
            ['name_menu' => 'Réanimation', 'numero_menu' =>'10'],
            ['name_menu' => 'Bloc Opératoire', 'numero_menu' =>'11'],
            ['name_menu' => 'Pharmacie', 'numero_menu' =>'12'],
            ['name_menu' => 'RH', 'numero_menu' =>'13'],
            ['name_menu' => 'Facturations', 'numero_menu' =>'14'],
            ['name_menu' => 'Trésorerie', 'numero_menu' =>'15'],
            ['name_menu' => 'Secrétariat', 'numero_menu' =>'16'],
            ['name_menu' => 'Logistique', 'numero_menu' =>'17'],
            ['name_menu' => 'Rapports', 'numero_menu' =>'18'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tconf_list_menu');
    }
}
