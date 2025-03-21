<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmedDetailSortieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmed_detail_sortie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteSortie')->constrained('tmed_entete_sortie')->restrictOnUpdate()->restrictOnDelete(); 
            $table->foreignId('refDetailMed')->constrained('tconf_detailmedicament')->restrictOnUpdate()->restrictOnDelete(); 
            $table->double('puSortie');
            $table->double('qteSortie');
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
        Schema::dropIfExists('tmed_detail_sortie');
    }
}
