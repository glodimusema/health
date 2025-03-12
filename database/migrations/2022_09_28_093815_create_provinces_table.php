<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idPays')->constrained('pays')->restrictOnUpdate()->restrictOnDelete();
            $table->string('nomProvince', 250);
            $table->timestamps();
        });

        DB::table('provinces')->insert([
            ['idPays' => 1,'nomProvince' => 'NORD-KIVU'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provinces');
    }
}
