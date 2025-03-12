<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimAnalyseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tim_analyse', function (Blueprint $table) {
            $table->id();
            $table->string('nomAnalyse',100);
            $table->double('prix',100);
            $table->double('prixConvention',100);
            $table->string('codeAnalyse',100);
            $table->foreignId('ReftypeAnalyse')->constrained('tim_type_analyse')->restrictOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('tim_analyse');
    }
}

