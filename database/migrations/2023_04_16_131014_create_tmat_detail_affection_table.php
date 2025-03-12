<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmatDetailAffectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmat_detail_affection', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refpatogramme')->constrained('tmat_partogramme')->restrictOnUpdate()->restrictOnDelete();
            $table->string('affection');
            $table->string('heure_apparition');
            $table->string('traitement_normaux');  
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
        Schema::dropIfExists('tmat_detail_affection');
    }
}
