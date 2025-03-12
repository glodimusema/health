<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimTypeAnalyseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tim_type_analyse', function (Blueprint $table) {
            $table->id();
            $table->string('nomTypeAnalyse', 100);  
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tim_type_analyse')->insert([
            ['nomTypeAnalyse' => 'SCANNER'],
            ['nomTypeAnalyse' => 'ECHOGRAPHIE'],
            ['nomTypeAnalyse' => 'RADIOGRAPHIE'],
            ['nomTypeAnalyse' => 'ECHO DOPPLER']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tim_type_analyse');
    }
}
