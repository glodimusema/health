<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopeDetailconsommationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tope_detailconsommation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteConso')->constrained('tope_enteteconsommation')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refmedicament')->constrained('tconf_detailmedicament')->restrictOnUpdate()->restrictOnDelete(); 
            $table->double('puCons');
            $table->double('qteCons');
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
        Schema::dropIfExists('tope_detailconsommation');
    }
}
