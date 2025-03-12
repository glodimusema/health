<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTMerePeriodeCponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_mere_periode_cpon', function (Blueprint $table) {
            $table->id();
            $table->string('name_periode');
            $table->string('dure_periode');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('t_mere_periode_cpon')->insert([
            ['name_periode' => 'Accouchées avec Complications du post-partum', 'dure_periode' => '0'],
            ['name_periode' => 'Accouchées ayant recu de la vitam A', 'dure_periode' => '0'],
            ['name_periode' => 'Accouchées ayant recu du Fer Folate', 'dure_periode' => '0'],
            ['name_periode' => 'Accouchées conseillées sur la PF', 'dure_periode' => '0'],
            ['name_periode' => 'CPON1 (6éme heure)', 'dure_periode' => '0'],
            ['name_periode' => 'CPON2 (6éme jour)', 'dure_periode' => '0'],
            ['name_periode' => 'CPON3 (42éme jour)', 'dure_periode' => '0'],
            ['name_periode' => 'Fistules vésico vaginales Nvcas', 'dure_periode' => '0'],
            ['name_periode' => 'Fmes allaitantes avec PB <230mm a la CPON3', 'dure_periode' => '0'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_mere_periode_cpon');
    }
}
