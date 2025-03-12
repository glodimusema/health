<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdyalVaccinDyaliseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdyal_vaccin_dyalise', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refcategorieVac')->constrained('tdyal_categorie_vaccin')->restrictOnUpdate()->restrictOnDelete();
            $table->string('nomVaccinDyal',250);
            $table->string('auther',250);
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tdyal_vaccin_dyalise')->insert([
            ['refcategorieVac' => 1,'nomVaccinDyal' => 'VAT1','auther' => 'Admin'],
            ['refcategorieVac' => 1,'nomVaccinDyal' => 'VAT2','auther' => 'Admin']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tdyal_vaccin_dyalise');
    }
}
