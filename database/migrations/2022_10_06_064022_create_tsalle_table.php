<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTsalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tsalle', function (Blueprint $table) {
            $table->id();
            $table->string('nom_salle');
            $table->double('PrixSalle');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tsalle')->insert([
            ['nom_salle' => 'SALLE COMMUNE', 'PrixSalle' => 20],
            ['nom_salle' => 'SALLE PRIVEE', 'PrixSalle' => 40]
        ]);
    }

    //PrixSalle
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tsalle');
    }
}
