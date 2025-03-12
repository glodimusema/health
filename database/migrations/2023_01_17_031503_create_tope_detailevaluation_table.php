<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopeDetailevaluationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tope_detailevaluation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteEva')->constrained('tope_enteteevaluation')->restrictOnUpdate()->restrictOnDelete();
            $table->string('jour');
            $table->date('dateDetailEva');
            $table->string('heure');
            $table->double('TA');
            $table->string('Pouls');
            $table->string('Dieurese');
            $table->string('Conscience');
            $table->string('Evolution');
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
        Schema::dropIfExists('tope_detailevaluation');
    }
}
