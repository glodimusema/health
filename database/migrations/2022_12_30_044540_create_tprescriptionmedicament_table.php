<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTprescriptionmedicamentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tprescriptionmedicament', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refdetailCons')->constrained('tdetailconsultation')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refmedicament')->constrained('tconf_medicament')->restrictOnUpdate()->restrictOnDelete();
            $table->double('quantite'); 
            $table->double('dosage', 250); 
            $table->string('detailprescription');           
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
        Schema::dropIfExists('tprescriptionmedicament');
    }
}
