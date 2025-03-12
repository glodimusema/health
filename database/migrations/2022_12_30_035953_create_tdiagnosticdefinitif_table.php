<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdiagnosticdefinitifTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdiagnosticdefinitif', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refdetailCons')->constrained('tdetailconsultation')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refmaladie')->constrained('tconf_maladie')->restrictOnUpdate()->restrictOnDelete();
            $table->text('descriptiondiagnostic',);
            $table->string('conclusion_maladie')->default('Vivant(2)');
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
        Schema::dropIfExists('tdiagnosticdefinitif');
    }
}
