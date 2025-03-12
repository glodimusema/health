<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTlitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tlit', function (Blueprint $table) {
            $table->id();
            $table->string('nom_lit');
            $table->foreignId('refSalle')->constrained('tsalle')->restrictOnUpdate()->restrictOnDelete();
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tlit')->insert([
            ['nom_lit' => '01', 'refSalle' => 1],
            ['nom_lit' => '02', 'refSalle' => 2]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tlit');
    }
}
