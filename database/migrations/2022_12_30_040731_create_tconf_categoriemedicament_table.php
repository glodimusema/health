<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTconfCategoriemedicamentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tconf_categoriemedicament', function (Blueprint $table) {
            $table->id();
            $table->string('nom_categoriemedicament', 250);
            $table->timestamps();
        });

        DB::table('tconf_categoriemedicament')->insert([
            ['nom_categoriemedicament' => 'MEDICAMENTS']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tconf_categoriemedicament');
    }
}
