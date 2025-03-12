<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenfantDetailTestCutaneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenfant_detail_test_cutane', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteTest')->constrained('tenfant_entete_test_cutane')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refTypeTest')->constrained('tenfant_type_test')->restrictOnUpdate()->restrictOnDelete();
            $table->string('taille');
            $table->string('lecture');
            $table->string('evaluation');
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
        Schema::dropIfExists('tenfant_detail_test_cutane');
    }
}
