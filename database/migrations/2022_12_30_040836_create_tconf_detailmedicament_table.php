<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTconfDetailmedicamentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tconf_detailmedicament', function (Blueprint $table) {
            $table->id();           
            $table->foreignId('refmedicament')->constrained('tconf_medicament')->restrictOnUpdate()->restrictOnDelete();
            $table->double('quantite'); 
            $table->date('dateexpiration');
            $table->date('dateEntree');           
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });
    }
    //dateEntree

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tconf_detailmedicament');
    }
}
