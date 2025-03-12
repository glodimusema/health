<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVillesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('villes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idProvince')->constrained('provinces')->restrictOnUpdate()->restrictOnDelete();
            $table->string('nomVille', 250);
            $table->timestamps();
        });

        DB::table('villes')->insert([
            ['idProvince' => 1,'nomVille' => 'GOMA'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('villes');
    }
}
