<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idVille')->constrained('villes')->restrictOnUpdate()->restrictOnDelete();
            $table->string('nomCommune', 250);
            $table->timestamps();
        });

        DB::table('communes')->insert([
            ['idVille' => 1,'nomCommune' => 'GOMA'],
            ['idVille' => 1,'nomCommune' => 'KARISIMBI'],
            ['idVille' => 1,'nomCommune' => 'NYIRAGONGO'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('communes');
    }
}
