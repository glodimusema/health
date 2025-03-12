<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTconfMethodeexamenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tconf_methodeexamen', function (Blueprint $table) {
            $table->id();
            $table->string('designation', 250);  
            $table->timestamps();
        });

        DB::table('tconf_methodeexamen')->insert([
            ['designation' => 'BS-200 ANALYSER BIOCHEMISTRY']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tconf_methodeexamen');
    }
}
