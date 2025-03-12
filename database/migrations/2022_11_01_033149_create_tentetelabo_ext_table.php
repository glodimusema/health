<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatetentetelaboExtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tentetelabo_ext', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refMouvement')->constrained('tmouvement')->restrictOnUpdate()->restrictOnDelete();  
            $table->integer('refExamen');
            $table->date('dateLabo');
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
        Schema::dropIfExists('tentetelabo_ext');
    }
}
