<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmaladiechroniqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmaladiechronique', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refMalade')->constrained('tclient')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refmaladie')->constrained('tconf_maladie')->restrictOnUpdate()->restrictOnDelete();
            $table->string('autredetail');         
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
        Schema::dropIfExists('tmaladiechronique');
    }
}
