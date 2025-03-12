<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTconfUnitevaleurTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tconf_unitevaleur', function (Blueprint $table) {
            $table->id();
            $table->string('designation', 250);  
            $table->timestamps();
        });

        DB::table('tconf_unitevaleur')->insert([
            ['designation' => 'mg/dl'],
            ['designation' => 'U/L'],
            ['designation' => 'mg/L'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tconf_unitevaleur');
    }
}
