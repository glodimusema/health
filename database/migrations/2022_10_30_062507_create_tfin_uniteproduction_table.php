<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTfinUniteproductionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tfin_uniteproduction', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refDepartement')->constrained('tfin_departement')->restrictOnUpdate()->restrictOnDelete();     
            $table->string('nom_uniteproduction');            
            $table->string('code_uniteproduction');
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tfin_uniteproduction')->insert([
            ['refDepartement' => 1,'nom_uniteproduction' => 'MEDECINE GENERALE','code_uniteproduction' => 'RPMG','author' => 'Admin'],
            ['refDepartement' => 1,'nom_uniteproduction' => 'URGENCES','code_uniteproduction' => 'RPUR','author' => 'Admin'],
            ['refDepartement' => 1,'nom_uniteproduction' => 'HOSPITALISATION','code_uniteproduction' => 'RPHO','author' => 'Admin'],
            ['refDepartement' => 1,'nom_uniteproduction' => 'NEONATOLOGIE','code_uniteproduction' => 'RPNEO','author' => 'Admin'],
            ['refDepartement' => 1,'nom_uniteproduction' => 'BLOC OPERATOIRE','code_uniteproduction' => 'RPOP','author' => 'Admin'],
            ['refDepartement' => 1,'nom_uniteproduction' => 'BLOC OPERATOIRE','code_uniteproduction' => 'RPOP','author' => 'Admin'],
            ['refDepartement' => 1,'nom_uniteproduction' => 'IMAGERIE','code_uniteproduction' => 'RPIM','author' => 'Admin'],
         ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tfin_uniteproduction');
    }
}
