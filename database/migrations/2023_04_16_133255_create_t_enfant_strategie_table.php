<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTEnfantStrategieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_enfant_strategie', function (Blueprint $table) {
            $table->id();
            $table->string('name_strategie');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('t_enfant_strategie')->insert([
            ['name_strategie' => 'Fixe'],
            ['name_strategie' => 'Mobile'],
            ['name_strategie' => 'Avancé'],
        ]);
    }
//Avancé
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_enfant_strategie');
    }
}
