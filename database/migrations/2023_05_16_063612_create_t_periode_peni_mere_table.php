<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPeriodePeniMereTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_periode_peni_mere', function (Blueprint $table) {
            $table->id();
            $table->string('name_periode');
            $table->string('dure_periode');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('t_periode_peni_mere')->insert([
            ['name_periode' => 'PENI1','dure_periode' => '0'],
            ['name_periode' => 'PENI2', 'dure_periode' => '0'],
            ['name_periode' => 'PENI3', 'dure_periode' => '0'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_periode_peni_mere');
    }
}
