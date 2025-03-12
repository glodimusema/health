<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatettypeconsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ttypeconsultation', function (Blueprint $table) {
            $table->id();            
            $table->string('designation');
            $table->double('PrixCons'); 
            $table->timestamps();
        });

        DB::table('ttypeconsultation')->insert([
            ['designation' => 'CONSULTATION GENERAL', 'PrixCons' => 10],
            ['designation' => 'CPN', 'PrixCons' => 10],
            ['designation' => 'CPS', 'PrixCons' => 10],
            ['designation' => 'CPON', 'PrixCons' => 10],
            ['designation' => 'CONSULTATION DENTISTERIE', 'PrixCons' => 10],
            ['designation' => 'CONSULTATION OPHTALMOLOGIE', 'PrixCons' => 10],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ttypeconsultations');
    }
}
