<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopeDetailanesthesieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tope_detailanesthesie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refAnesthesie')->constrained('tope_anesthesie')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refTypeAnesthesie')->constrained('tope_typeanesthesie')->restrictOnUpdate()->restrictOnDelete();
            $table->string('detail_affectAnesthesie');
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
        Schema::dropIfExists('tope_detailanesthesie');
    }
}
