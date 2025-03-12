<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTneroAnnexeNeuroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tnero_annexe_neuro', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refProtocole')->constrained('tnero_protocole_neurologie')->restrictOnUpdate()->restrictOnDelete();
            $table->string('pdfNeuro',100);
            $table->string('descriptionPFD',100);
            $table->string('author',100);
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
            //author
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tnero_annexe_neuro');
    }
}
