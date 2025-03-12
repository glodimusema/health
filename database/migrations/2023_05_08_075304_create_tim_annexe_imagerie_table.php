<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimAnnexeImagerieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tim_annexe_imagerie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refImagerie')->constrained('tim_imagerie')->restrictOnUpdate()->restrictOnDelete();
            $table->string('pdfImagerie',100);
            $table->string('desicriptionPDF',100);
            $table->string('author',50);
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });
    }

    //id,refImagerie,desicriptionPDF,author

    //id,refImagerie,pdfImagerie,desicriptionPDF,author

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tim_annexe_imagerie');
    }
}
