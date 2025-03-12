<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTserviceHopitalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tservice_hopital', function (Blueprint $table) {
            $table->id();
            $table->string('nom_service');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tservice_hopital')->insert([
            ['nom_service' => 'CONSULTATION'],
            ['nom_service' => 'SERVICE DE SOIN']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tservice_hopital');
    }
}
