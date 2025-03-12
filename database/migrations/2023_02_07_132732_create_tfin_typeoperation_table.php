<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
class CreateTfinTypeoperationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tfin_typeoperation', function (Blueprint $table) {
            $table->id();
            $table->string('nom_typeoperation');
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tfin_typeoperation')->insert([
            ['nom_typeoperation' => 'DEBIT','author' => 'Admin'],
            ['nom_typeoperation' => 'CREDIT','author' => 'Admin']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tfin_typeoperation');
    }
}
