<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimResultatFOGDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tim_resultat_f_o_g_d', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refImagerie')->constrained('tim_imagerie')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateResultat');
            $table->string('oesophase',100);
            $table->string('cardia',100);
            $table->string('lacmugueux',100);
            $table->string('fundus',100);
            $table->string('autres',100);
            $table->string('pylore',100);
            $table->string('bulbe',100);
            $table->string('deuxiemeDuo',100);
            $table->string('biopseis',100);
            $table->string('conclusion',100);
            $table->string('photo_resultat',100);
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
        Schema::dropIfExists('tim_resultat_f_o_g_d');
    }
}
