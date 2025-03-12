<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTservicehospiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tservicehospi', function (Blueprint $table) {
            $table->id();
            $table->string('nom_servicehospi');            
            $table->double('prix_servicehospi');
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tservicehospi')->insert([
            ['nom_servicehospi' => 'NARCING','prix_servicehospi' => 10, 'author' => 'Admin']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tservicehospi');
    }
}
