<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTMerePeriodeSpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_mere_periode_sp', function (Blueprint $table) {
            $table->id();
            $table->string('name_periode_Sp');
            $table->string('dure_periode_sp');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('t_mere_periode_sp')->insert([
            ['name_periode_Sp' => 'SP1','dure_periode_sp' => '0'],
            ['name_periode_Sp' => 'SP2','dure_periode_sp' => '0'],
            ['name_periode_Sp' => 'SP3','dure_periode_sp' => '0'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_mere_periode_sp');
    }
}
