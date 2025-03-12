<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
class CreatetcategoriemedecinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcategoriemedecin', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('designation'); 
        });

        DB::table('tcategoriemedecin')->insert([
            ['designation' => 'NON PERMANENT'],
            ['designation' => 'PERMANENT'],
            ['designation' => 'VISITEUR'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tcategoriemedecin');
    }
}
