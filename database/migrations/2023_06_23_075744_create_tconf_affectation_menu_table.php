<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
class CreateTconfAffectationMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tconf_affectation_menu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refRole')->constrained('roles')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refMenu')->constrained('tconf_list_menu')->restrictOnUpdate()->restrictOnDelete();
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user');         
            $table->timestamps();
        });

        //author

        DB::table('tconf_affectation_menu')->insert([
            [ 'refRole' => 1, 'refMenu' => 1, 'author' => 'Admin'],
            [ 'refRole' => 1, 'refMenu' => 2, 'author' =>'Admin'],
            [ 'refRole' => 1, 'refMenu' => 3, 'author' =>'Admin'],
            [ 'refRole' => 1, 'refMenu' => 4, 'author' =>'Admin'],
            [ 'refRole' => 1, 'refMenu' => 5, 'author' =>'Admin'],
            [ 'refRole' => 1, 'refMenu' => 6, 'author' =>'Admin'],
            [ 'refRole' => 1, 'refMenu' => 7, 'author' =>'Admin'],
            [ 'refRole' => 1, 'refMenu' => 8, 'author' =>'Admin'],
            [ 'refRole' => 1, 'refMenu' => 9, 'author' =>'Admin'],
            [ 'refRole' => 1, 'refMenu' => 10, 'author' =>'Admin'],
            [ 'refRole' => 1, 'refMenu' => 11, 'author' =>'Admin'],
            [ 'refRole' => 1, 'refMenu' => 12, 'author' =>'Admin'],
            [ 'refRole' => 1, 'refMenu' => 13, 'author' =>'Admin'],
            [ 'refRole' => 1, 'refMenu' => 14, 'author' =>'Admin'],
            [ 'refRole' => 1, 'refMenu' => 15, 'author' =>'Admin'],
            [ 'refRole' => 1, 'refMenu' => 16, 'author' =>'Admin'],
            [ 'refRole' => 1, 'refMenu' => 17, 'author' =>'Admin'],
            [ 'refRole' => 1, 'refMenu' => 18, 'author' =>'Admin'],
    
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tconf_affectation_menu');
    }
}
