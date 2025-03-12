<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmedDetailbesoinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmed_detailbesoin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteVente')->constrained('tmouvement')->restrictOnUpdate()->restrictOnDelete();  
            $table->foreignId('refmedicament')->constrained('tconf_medicament')->restrictOnUpdate()->restrictOnDelete();
            $table->double('qte_besoin');
            $table->double('pu_besoin');
            $table->string('observation_besoin');
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
        Schema::dropIfExists('tmed_detailbesoin');
    }
}
