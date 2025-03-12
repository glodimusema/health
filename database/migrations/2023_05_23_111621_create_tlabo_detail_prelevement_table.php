<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTlaboDetailPrelevementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //tlabo_detail_prelevement : id,refEntetePrelevement,refEchantillon,author
        Schema::create('tlabo_detail_prelevement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEntetePrelevement')->constrained('tlabo_entete_prelevement')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refEchantillon')->constrained('tconf_natureechantillon')->restrictOnUpdate()->restrictOnDelete();
            $table->string('author',50); 
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
        Schema::dropIfExists('tlabo_detail_prelevement');
    }
}
