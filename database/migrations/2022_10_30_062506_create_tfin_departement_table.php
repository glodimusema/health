<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTfinDepartementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tfin_departement', function (Blueprint $table) {
            $table->id();
            $table->string('nom_departement');
            $table->string('code_departement');
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tfin_departement')->insert([
            ['nom_departement' => 'RECEPTION PRINCIPALE','code_departement' => 'RP','author' => 'Admin'],
            // ['nom_departement' => 'RECEPTION IMAGERIE','code_departement' => 'RI','author' => 'Admin'],
            // ['nom_departement' => 'RECEPTION DENTISTERIE','code_departement' => 'RD','author' => 'Admin'],
            // ['nom_departement' => 'RECEPTION CARDIOLOGIE','code_departement' => 'RC','author' => 'Admin'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tfin_departement');
    }
}
