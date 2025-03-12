<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatetproduitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tproduit', function (Blueprint $table) {
            $table->id();
            $table->string('designation'); 
            $table->double('pu'); 
            $table->double('qte')->default(0); 
            $table->string('unite'); 
            $table->foreignId('refCategorie')->constrained('tcategorieproduit')->restrictOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('tproduit');
    }
}
