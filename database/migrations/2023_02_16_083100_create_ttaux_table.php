<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 

class CreateTtauxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ttaux', function (Blueprint $table) {
            $table->id();
            $table->double('montant_taux');
            $table->timestamps();
        });

        DB::table('ttaux')->insert([
            ['montant_taux' => 2600]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ttaux');
    }
}
