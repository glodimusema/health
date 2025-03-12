<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtubeexamenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ttubeexamen', function (Blueprint $table) {
            $table->id();
            $table->string('codeTube');  
            $table->string('designationTube');
            $table->string('couleurTube');
            $table->string('author');
            $table->timestamps();
        });

        DB::table('ttubeexamen')->insert([
            ['codeTube' => 'S','designationTube' => 'Tube Serum','couleurTube' => 'Rouge','author' => 'Admin'],
            ['codeTube' => 'C','designationTube' => 'Tube Citrate','couleurTube' => 'Bleu Ciel','author' => 'Admin'],
            ['codeTube' => 'H','designationTube' => 'Tube Héparine','couleurTube' => 'Verte','author' => 'Admin'],
            ['codeTube' => 'E','designationTube' => 'Tube EDTA','couleurTube' => 'Mauve','author' => 'Admin'],
            ['codeTube' => 'F','designationTube' => 'Tube Fluoride','couleurTube' => 'Grise','author' => 'Admin'],
            ['codeTube' => 'F','designationTube' => 'Tube Sec','couleurTube' => 'Grise','author' => 'Admin'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ttubeexamen');
    }
}
