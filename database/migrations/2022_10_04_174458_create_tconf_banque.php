<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTconfBanque extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tconf_banque', function (Blueprint $table) {
            $table->id();
            $table->string('nom_banque');
            $table->string('numerocompte');
            $table->string('nom_mode');
            $table->foreignId('refSscompte')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete();
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tconf_banque')->insert([
            ['nom_banque' => 'CAISSE','numerocompte' => '000000000000','nom_mode' => 'CASH','refSscompte' => 2, 'author' => 'Admin'],
            ['nom_banque' => 'EQUITY BANK','numerocompte' => '000000000000','nom_mode' => 'BANQUE','refSscompte' => 1, 'author' => 'Admin'],
            ['nom_banque' => 'TMB','numerocompte' => '000000000000','nom_mode' => 'BANQUE','refSscompte' => 1, 'author' => 'Admin'],
            ['nom_banque' => 'ECOBANK','numerocompte' => '000000000000','nom_mode' => 'BANQUE','refSscompte' => 1, 'author' => 'Admin']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tconf_banque');
    }
}
