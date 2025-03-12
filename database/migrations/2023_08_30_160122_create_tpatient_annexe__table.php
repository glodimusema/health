<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpatientAnnexeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tpatient_annexe_', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refPatient')->constrained('tClient')->restrictOnUpdate()->restrictOnDelete();
            $table->string('pdfPatient',100);
            $table->string('desicriptionPDF',100);
            $table->string('author',50);
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
        Schema::dropIfExists('tpatient_annexe_');
    }
}
