<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimResultatImagerieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tim_resultat_imagerie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refImagerie')->constrained('tim_imagerie')->restrictOnUpdate()->restrictOnDelete();
            $table->text('technique_res');
            $table->text('description_res');
            $table->string('conclusion_res',100);
            $table->string('image_res',100); 
            $table->string('author',100);     
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
        Schema::dropIfExists('tim_resultat_imagerie');
    }
}
