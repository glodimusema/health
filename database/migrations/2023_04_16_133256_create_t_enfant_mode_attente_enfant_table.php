<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTEnfantModeAttenteEnfantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_enfant_mode_attente_enfant', function (Blueprint $table) {
            $table->id();
            $table->string('name_mode');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });


        DB::table('t_enfant_mode_attente_enfant')->insert([
            ['name_mode' => 'Sensibilisation'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_enfant_mode_attente_enfant');
    }
}
