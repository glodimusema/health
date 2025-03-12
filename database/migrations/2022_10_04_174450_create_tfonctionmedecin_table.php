<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
class CreatetfonctionmedecinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tfonctionmedecin', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('designation'); 
        });

        DB::table('tfonctionmedecin')->insert([
            ['designation' => 'CONSULTATION'],
            ['designation' => 'LABORATOIRE'],
            ['designation' => 'COMPTABLE'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tfonctionmedecin');
    }
}
