<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimCardiologieExtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tim_cardiologie_ext', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refImagerie')->constrained('tim_imagerie_ext')->restrictOnUpdate()->restrictOnDelete();
            $table->string('indication',100);
            $table->string('ventriculeGauche',100);
            $table->string('ventriculeDroite',100);
            $table->string('oreillette',100);
            $table->string('valve',100);
            $table->string('oesophage',100);
            $table->string('autres',100);
            $table->string('conclusionCardio',100);
            $table->string('imageCardio');
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
        Schema::dropIfExists('tim_cardiologie_ext');
    }
}
