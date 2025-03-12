<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtTresoBlocTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tt_treso_bloc', function (Blueprint $table) {
            $table->id();
            $table->string('desiBloc');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tt_treso_bloc')->insert([
            ['desiBloc' => 'COORDINATION'],
            ['desiBloc' => 'DIVISION'],
            ['desiBloc' => 'SERVICE']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tt_treso_bloc');
    }
}
