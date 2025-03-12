<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmedEntetebesoinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('tmed_entetebesoin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refService')->constrained('tservice_hopital')->restrictOnUpdate()->restrictOnDelete();  
            $table->foreignId('refMouvement')->constrained('tmouvement')->restrictOnUpdate()->restrictOnDelete();  
            $table->foreignId('refSalle')->constrained('tsalle')->restrictOnUpdate()->restrictOnDelete();           
            $table->date('date_besoin');
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
        Schema::dropIfExists('tmed_entetebesoin');
    }
}
