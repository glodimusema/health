<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdetailsortiehospitaliserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdetailsortiehospitaliser', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refSortriHospi')->constrained('tsortiehospitaliser')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refServiceHospi')->constrained('tservicehospi')->restrictOnUpdate()->restrictOnDelete();           
            $table->double('nombreJour'); 
            $table->string('autreDetails');
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tdetailsortiehospitaliser');
    }
}
