<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmedDetailEntreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmed_detail_entree', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteEntree')->constrained('tmed_entete_entree')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refmedicament')->constrained('tconf_medicament')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateExpiration');
            $table->string('numeroLot');
            $table->double('puEntree');
            $table->double('qteEntree');
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
        Schema::dropIfExists('tmed_detail_entree');
    }
}
