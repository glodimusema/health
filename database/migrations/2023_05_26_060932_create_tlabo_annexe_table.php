<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTlaboAnnexeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tlabo_annexe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteLabo')->constrained('tentetelabo')->restrictOnUpdate()->restrictOnDelete();
            $table->string('pdfLabo',100);
            $table->string('descriptionImage',100);
            $table->string('author',100);
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });
    }
    //author

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tlabo_annexe');
    }
}
