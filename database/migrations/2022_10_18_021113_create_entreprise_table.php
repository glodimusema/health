<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntrepriseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entreprise', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idProvince')->constrained('provinces')->restrictOnUpdate()->restrictOnDelete();
            $table->integer('ceo');
            $table->string('nom', 250)->nullable();
            $table->string('email', 250)->nullable();
            $table->string('adresse', 250)->nullable();
            $table->string('tel1', 250)->nullable();
            $table->string('tel2', 250)->nullable();
            $table->string('siteweb', 250)->nullable(); 
            $table->string('facebook', 250)->nullable();
            $table->string('twitter', 250)->nullable();
            $table->string('linkedin', 250)->nullable();                  
            $table->string('idnational', 250)->nullable();
            $table->string('rccm', 250)->nullable();
            $table->string('numImpot', 250)->nullable();
            $table->string('logo', 250)->nullable();
            $table->integer('id_user_insert')->nullable();
            $table->integer('id_user_update')->nullable();
            $table->integer('id_user_delete')->nullable();
            $table->string('busnessName', 250)->nullable();
            $table->string('codeBusness', 250)->nullable();
            $table->integer('idSecteur')->nullable();
            $table->string('contactNumCode', 250)->nullable();
            $table->string('anneeFondation', 250)->nullable();
            $table->string('numCaisseSocial', 250)->nullable();
            $table->string('numInpp', 250)->nullable();
            $table->string('idForme', 250)->nullable();
            $table->string('numPersonneJuridique', 250)->nullable();
            $table->string('slug', 250)->nullable();
            $table->integer('statut')->default(1);

            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('entreprise')->insert([
            ['idProvince' => 1,'ceo' => 1,'nom' => 'NEW HORIZON','email' => 'new-horizon@gmail.com','adresse' => 'NDOSHO',
            'tel1'=> '+243990000000','tel2'=> '+243850000000','siteweb'=> 'www.new-horizon.com','facebook'=> 'new-horizon',
            'twitter'=> 'new-horizon','linkedin'=> 'new-horizon','idnational'=> '000000',
            'rccm'=> '0000','numImpot'=> '0000','logo'=> 'avatar.php','id_user_insert'=> 1,
            'id_user_update'=> 1,'id_user_delete'=> 1,'busnessName'=> 'CLINIC NEW HORISON',
            'codeBusness'=> '0000','idSecteur'=> 1,'contactNumCode'=> '000000',
            'anneeFondation'=> '2000','numCaisseSocial'=> '00000','numInpp'=> '0000000',
            'idForme'=> '1','numPersonneJuridique'=> '0000', 'slug'=> '000000',],
        ]);
    }
 
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entreprise');
    }
}
