<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
class CreateTfinTypepositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tfin_typeposition', function (Blueprint $table) {
            $table->id();
            $table->string('nom_typeposition');
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });
        DB::table('tfin_typeposition')->insert([
            ['nom_typeposition' => 'D', 'author' => 'Admin'],
            ['nom_typeposition' => 'C', 'author' => 'Admin']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tfin_typeposition');
    }
}
