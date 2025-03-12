<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThospiTypePlaieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thospi_type_plaie', function (Blueprint $table) {
            $table->id();
            $table->string('nomTypePlaie');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('thospi_type_plaie')->insert([
            ['nomTypePlaie' => 'GROS'],
            ['nomTypePlaie' => 'MOYEN']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thospi_type_plaie');
    }
}
