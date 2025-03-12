<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTconfMaladieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tconf_maladie', function (Blueprint $table) {
            $table->id();
            $table->string('nom_maladie', 250);  
            $table->foreignId('refcategoriemaladie')->constrained('tconf_categoriemaladie')->restrictOnUpdate()->restrictOnDelete();
            $table->string('author')->default('Admin');
            $table->timestamps();
        });


        DB::table('tconf_maladie')->insert([
            ['nom_maladie' =>'Diabète','refcategoriemaladie' => 1],
            ['nom_maladie' =>'Cholera','refcategoriemaladie' => 2],
            ['nom_maladie' =>'SIDA','refcategoriemaladie' => 1],
            ['nom_maladie' =>'Autres','refcategoriemaladie' => 3],
            ['nom_maladie' =>'PARODONTOPATHIE AIGUIE CHRONIQUE','refcategoriemaladie' => 1],
            ['nom_maladie' =>'STOMATOLOGIE','refcategoriemaladie' => 1],
            ['nom_maladie' =>'PROTHESE DENTAIRE','refcategoriemaladie' => 1],
            ['nom_maladie' =>'PEDODONTIE','refcategoriemaladie' => 1],
            ['nom_maladie' =>'DENTCARIEE OU CARIE DENTAIRE','refcategoriemaladie' => 1],
            ['nom_maladie' =>'DECHAUSSEMENT DENTAIRE','refcategoriemaladie' => 1],
            ['nom_maladie' =>'GINGIVITE AIGUEE CHRONIQUE','refcategoriemaladie' => 1],
            ['nom_maladie' =>'HUPOPLASIE DENTAIRE','refcategoriemaladie' => 1],
            ['nom_maladie' =>'PULPITE','refcategoriemaladie' => 1],
            ['nom_maladie' =>'ABCES DENTAIRE','refcategoriemaladie' => 1],
            ['nom_maladie' =>'BRUXISME OU GRINCEMENT DENTAIRE','refcategoriemaladie' => 1],
            ['nom_maladie' =>'APTITE BRUCCALE','refcategoriemaladie' => 1],
            ['nom_maladie' =>'DYSTRARMONIE DENTO-FACIALE SIMPLE, COMPLEXE','refcategoriemaladie' => 1],
            ['nom_maladie' =>'DYSCROMIE DENTAIRE','refcategoriemaladie' => 1],
            ['nom_maladie' =>'FRACTURE CORONAIRE','refcategoriemaladie' => 1],
            ['nom_maladie' =>'FRACTURE RADICULAIRE','refcategoriemaladie' => 1],
            ['nom_maladie' =>'FRACTURE MONIPULAIRE, PARASYMPHYSAIRE, DE TROU MENTONIER DE BM DE BH DES CONDULES','refcategoriemaladie' => 1],
            ['nom_maladie' =>'DENTINITE','refcategoriemaladie' => 1],
            ['nom_maladie' =>'NECROSE PULPAIRE','refcategoriemaladie' => 1],
            ['nom_maladie' =>'PERIODONTITE AIGUI SIMPLE CHRONIQUE','refcategoriemaladie' => 1],
            ['nom_maladie' =>'CELLILITE','refcategoriemaladie' => 1],

        ]);





    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tconf_maladie');
    }
}
