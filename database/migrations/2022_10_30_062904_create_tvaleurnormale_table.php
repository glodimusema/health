<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatetvaleurnormaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvaleurnormale', function (Blueprint $table) {
            $table->id();
            $table->string('designation', 250);  
            $table->foreignId('refExamen')->constrained('texamen')->restrictOnUpdate()->restrictOnDelete();
            $table->string('detailValeur', 250);
            $table->string('unite', 250);
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
        Schema::dropIfExists('tvaleurnormale');
    }
}
