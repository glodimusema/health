<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThospiServiceHospiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thospi_service_hospi', function (Blueprint $table) {
            $table->id();
            $table->string('nomServiceHospi');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('thospi_service_hospi')->insert([
            ['nomServiceHospi' => 'HOSPITALISATION'],
            ['nomServiceHospi' => 'MEDICAL']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thospi_service_hospi');
    }
}
