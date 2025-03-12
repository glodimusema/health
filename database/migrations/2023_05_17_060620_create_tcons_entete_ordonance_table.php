<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTconsEnteteOrdonanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcons_entete_ordonance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refdetailCons')->constrained('tdetailconsultation')->restrictOnUpdate()->restrictOnDelete();
            $table->date('date_ordonance');           
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
        Schema::dropIfExists('tcons_entete_ordonance');
    }
}
