<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuartiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quartiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idCommune')->constrained('communes')->restrictOnUpdate()->restrictOnDelete();
            $table->string('nomQuartier', 250);
            $table->timestamps();
        });

        DB::table('quartiers')->insert([
            ['idCommune' => 1,'nomQuartier' => 'HIMBI1'],
            ['idCommune' => 1,'nomQuartier' => 'KYESHERO'],
            ['idCommune' => 1,'nomQuartier' => 'LE VOLCAN'],
            ['idCommune' => 2,'nomQuartier' => 'NDOSHO'],
            ['idCommune' => 2,'nomQuartier' => 'KATINDO2'],
            ['idCommune' => 2,'nomQuartier' => 'MABANGA-SUD'],
            ['idCommune' => 2,'nomQuartier' => 'MAJENGO'],
            ['idCommune' => 2,'nomQuartier' => 'KATOYI'],
            ['idCommune' => 2,'nomQuartier' => 'MIKENO'],
            ['idCommune' => 2,'nomQuartier' => 'MAPENDO'],
            ['idCommune' => 2,'nomQuartier' => 'KATINDO'],
            ['idCommune' => 2,'nomQuartier' => 'HIMBI2'],
            ['idCommune' => 2,'nomQuartier' => 'LAC VERT'],
            ['idCommune' => 2,'nomQuartier' => 'KAHEMBE'],
            ['idCommune' => 2,'nomQuartier' => 'KASIKA'],
            ['idCommune' => 2,'nomQuartier' => 'MURARA'],
            ['idCommune' => 2,'nomQuartier' => 'VIRUNGA'],
            ['idCommune' => 2,'nomQuartier' => 'MUGUNGA'],
            ['idCommune' => 2,'nomQuartier' => 'BUJOVU'],
            ['idCommune' => 2,'nomQuartier' => 'NGANGI II'],
            ['idCommune' => 2,'nomQuartier' => 'MAKAO'],
        ]);
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quartiers');
    }
}
